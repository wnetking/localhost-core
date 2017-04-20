(function($) {
  //var xhr = $.ajaxSettings.xhr();
  //xhr.multipart = true;
  //xhr.open('POST', './index.php', true);
  //xhr.onreadystatechange = function() {
  //  if (xhr.readyState == 4) {
  //    console.log(xhr.responseText);
  //  }
  //};
  //xhr.send(null);
  var optimizer = {
    ajax        : function() {
      this.init    = function(options) {
        this.options = $.extend(this.options, options);
        this.request();
        return this;
      };
      this.options = {
        type     : 'POST',
        url      : './index.php',
        headers  : {"cache-control" : "no-cache"},
        cache    : false,
        dataType : "json",
        async    : false,
        success  : function() {
        }
      };
      this.request = function() {
        $.ajax(this.options);
      };
    },
    time        : function() {
      this.format = function(ms) {
        var sec     = ms / 1000
          , hours   = sec / 3600 % 24
          , minutes = sec / 60 % 60
          , seconds = sec % 60
          ;
        return this.num(hours) + "h " + this.num(minutes) + "m " + this.num(seconds) + 's';
      };
      this.num    = function(val) {
        val = Math.floor(val);
        return val < 10 ? '0' + val : val;
      }
    },
    formatBytes : function(bytes, decimals) {
      if (bytes == 0) {
        return '0 Byte';
      }
      var k     = 1000;
      var dm    = decimals + 1 || 3;
      var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
      var i     = Math.floor(Math.log(bytes) / Math.log(k));
      return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
    }
  };
  $(document).ready(function() {
    var ajax = new optimizer.ajax();
    $('body').on('click', '.complete a', function(e) {
      e.preventDefault();
      var options = {
        data    : {
          action : 'download'
        },
        success : function(response) {
          location.href = response.zipfile;
        }
      };
      console.log('1');
      ajax.init(options);
    });
    $('#optimize').on('click', function(e) {
      e.preventDefault();
      if ($('#path').val() != '') {
        var options = {
          data    : {
            action  : 'getAllFiles',
            path    : $('#path').val(),
            replace : $('#replace').is(':checked')
          },
          success : function(response) {
            if (response.status == true) {
              $('.alert-danger').addClass('hidden');
              var connect = false;
              $('#content form').addClass('hidden');
              $('#content .progress').removeClass('hidden');
              var files;
              var file_index = 0;
              if ($('#replace').is(':checked')) {
                $('.complete a').addClass('hidden');
              }
              files            = response.files;
              var allTime      = 0;
              var savedSize    = 0;
              var ajaxInterval = setInterval(function() {
                if (!connect && file_index < files.length) {
                  var start_time = new Date().getTime();
                  connect        = true;
                  var ajax       = new optimizer.ajax();
                  var options    = {
                    data    : {
                      action : 'next',
                      files  : JSON.stringify(files.slice(file_index, file_index + 1)),
                      path   : $('#path').val()
                    },
                    success : function(response) {
                      allTime += (new Date().getTime() - start_time) / 1000;
                      savedSize += response.size;
                      if (file_index < files.length - 1) {
                        file_index += 1;
                        var percent = (file_index / (files.length - 1)) * 100;
                        $('.progress span.percent').html(parseInt(percent) + '% Complete (success)' + '<br>Files: ' + file_index + '/' + files.length + '<br>Saved: ' + optimizer.formatBytes(savedSize));
                        $('.progress-bar').css('width', percent + '%');
                        connect = false;
                      } else {
                        clearInterval(ajaxInterval);
                        var time = new optimizer.time();
                        $('.progress span.percent').addClass('hidden');
                        $('.progress-bar').css('width', '100%');
                        $('.progress span.complete')
                          .html($('.progress span.complete').html() + '<br>Time:' + time.format(allTime * 1000) + '<br>Saved:' + optimizer.formatBytes(savedSize))
                          .removeClass('hidden');
                      }
                    },
                    error   : function() {
                      connect = false;
                      file_index += 1;
                    }
                  };
                  ajax.init(options);
                }
              }, 500);
            } else {
              $('.alert-danger').removeClass('hidden').text(response.error);
            }
          }
        };
        ajax.init(options);
      }
    });
  });
})(jQuery);