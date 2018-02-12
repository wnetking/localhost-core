import {h, Component} from 'preact';
import ProjectList from './components/ProjectList'
import './App.css';

class App extends Component {
  render() {
    return (
      <div className="container">
        /* eslint-disable-next-line */
        <ProjectList data={window.data || []}/>
      </div>
    );
  }
}

export default App;
