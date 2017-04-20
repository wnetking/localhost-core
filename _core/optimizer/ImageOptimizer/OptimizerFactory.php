<?php


namespace ImageOptimizer;


use ImageOptimizer\Exception\Exception;
use ImageOptimizer\TypeGuesser\TypeGuesser;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Process\ExecutableFinder;

class OptimizerFactory
{
    const OPTIMIZER_SMART = 'smart';

    private $optimizers = array();
    private $options;
    private $executableFinder;
    private $logger;

    public function __construct(array $options = array(), LoggerInterface $logger = null)
    {
        $this->executableFinder = new ExecutableFinder();
        $this->logger = $logger ?: new NullLogger();

        $this->setOptions($options);
        $this->setUpOptimizers();
    }

    private function setOptions(array $options)
    {
        $this->options = $this->getOptionsResolver()->resolve($options);
    }

    protected function getOptionsResolver()
    {
        $resolver = new OptionsResolver();
        $resolver->setDefaults(array(
            'ignore_errors' => true,
            'jpegoptim_options' => array('-f', '-s', '--max=85'),
            'pngquant_options' => array('--speed 3 256'),
            'ect_options' => array('')

        ));

        $method = is_callable(array($resolver, 'setDefined')) ? 'setDefined' : 'setOptional';

        $resolver->$method(array(
            'jpegoptim_bin',
            'pngquant_bin',
            'ect_bin'
        ));

        return $resolver;
    }

    protected function setUpOptimizers()
    {
        $this->optimizers['pngquant'] = $this->wrap(new CommandOptimizer(
            new Command($this->executable('pngquant'), $this->options['pngquant_options']),
            function($filepath){
                $ext = pathinfo($filepath, PATHINFO_EXTENSION);
                return array($filepath, '-f -o ');
            }
        ));

        $this->optimizers['ect'] = $this->wrap(new CommandOptimizer(
            new Command($this->executable('ect'), $this->options['ect_options'])
        ));

        $this->optimizers['png'] = new ChainOptimizer(array(
            $this->optimizers['pngquant'],
            $this->optimizers['ect']
        ));

        $this->optimizers['jpegoptim'] = $this->wrap(new CommandOptimizer(
            new Command($this->executable('jpegoptim'), $this->options['jpegoptim_options'])
        ));

        $this->optimizers['jpeg'] = $this->optimizers['jpg'] = new ChainOptimizer(array(
            $this->unwrap($this->optimizers['jpegoptim']),
        ), true);

        $this->optimizers[self::OPTIMIZER_SMART] = $this->wrap(new SmartOptimizer(array(
            TypeGuesser::TYPE_PNG => $this->optimizers['png'],
            TypeGuesser::TYPE_JPEG => $this->optimizers['jpeg'],
        )));
    }

    private function wrap(Optimizer $optimizer)
    {
        return $this->option('ignore_errors', true) ? new SuppressErrorOptimizer($optimizer, $this->logger) : $optimizer;
    }

    private function unwrap(Optimizer $optimizer)
    {
        return $optimizer instanceof SuppressErrorOptimizer ? $optimizer->unwrap() : $optimizer;
    }

    private function executable($name)
    {
        $executableFinder = $this->executableFinder;
        return $this->option($name.'_bin', function() use($name, $executableFinder){
            return $executableFinder->find($name, $name);
        });
    }

    private function option($name, $default = null)
    {
        return isset($this->options[$name]) ? $this->options[$name] : $this->resolveDefault($default);
    }

    /**
     * @param string $name
     * @return Optimizer
     * @throws Exception When requested optimizer does not exist
     */
    public function get($name = self::OPTIMIZER_SMART)
    {
        if(!isset($this->optimizers[$name])) {
            throw new Exception(sprintf('Optimizer "%s" not found', $name));
        }

        return $this->optimizers[$name];
    }

    private function resolveDefault($default)
    {
        return is_callable($default) ? call_user_func($default) : $default;
    }
}
