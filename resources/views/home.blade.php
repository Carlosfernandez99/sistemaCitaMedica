@extends('layouts.app', ['page' => __('User Profile'), 'pageSlug' => 'profile'])

@section('content')
<div class="row">
  <div class="col-md-12 mb-4">
      <div class="card">
          <div class="card-header">Administracion</div>
          <div class="card-body">
              @if (session('status'))
                  <div class="alert alert-success" role="alert">
                      {{ session('status') }}
                  </div>
              @endif
              Bienvenido! Por favor selecciona una opción del menú lateral izquierdo.
          </div>
      </div>
  </div>

  @if (Auth::user()->rol_usuario == 'administrador')
    <div class="col-xl-6 mb-5 mb-xl-0">
      <div class="card shadow">
        <div class="card-header bg-transparent">
          <div class="row align-items-center">
            <div class="col">
              <h6 class="text-uppercase ls-1 mb-1">Notificación General</h6>
              <h2 class="mb-0">Enviar a todos los usuarios</h2>
            </div>
          </div>
        </div>
        <div class="card-body">
        @if (session('notificacion'))
          <div class="alert alert-success" role="alert">
            {{ session('notificacion') }}
          </div>
        @endif

          <form action="{{ url('/fcm/send') }}" method="post">
            @csrf
            <div class="form-group">
              <label for="title">Título</label>
              <input value="{{ config('app.name') }}" type="text" class="form-control" name="title" id="title" required>
            </div>
            <div class="form-group">
              <label for="body">Mensaje</label>
              <textarea name="body" id="body" rows="2" class="form-control" required></textarea>
            </div>
            <button class="btn btn-primary">Enviar notificación</button>
          </form>
        </div>
      </div>
    </div>
    <div class="col-xl-6">
      <div class="card shadow">
        <div class="card-header bg-transparent">
          <div class="row align-items-center">
            <div class="col">
              <h6 class="text-uppercase text-muted ls-1 mb-1">Total de citas</h6>
              <h2 class="mb-0">Según día de la semana</h2>
            </div>
          </div>
        </div>
        <div class="card-body">
          <!-- Chart -->
          <div class="chart">
            <canvas id="chart-orders" class="chart-canvas"></canvas>
          </div>
        </div>
      </div>
    </div>
  @endif
</div>
@endsection

@section('scripts')
  <script>
    const consultamedicaPorDia = @json($consultamedicaPorDia);
  </script>
  <script src="{{ asset('js/charts/home.js') }}"></script>
  <script>
    'use strict';
    var Popover = (function() {
      // Variables
      var $popover = $('[data-toggle="popover"]'),
        $popoverClass = '';

      // Methods
      function init($this) {
        if ($this.data('color')) {
          $popoverClass = 'popover-' + $this.data('color');
        }

        var options = {
          trigger: 'focus',
          template: '<div class="popover ' + $popoverClass + '" role="tooltip"><div class="arrow"></div><h3 class="popover-header"></h3><div class="popover-body"></div></div>'
        };
        $this.popover(options);
      }

      // Events
      if ($popover.length) {
        $popover.each(function() {
          init($(this));
        });
      }
    })();

    'use strict';
    var Charts = (function() {
      // Variable
      var $toggle = $('[data-toggle="chart"]');
      var mode = 'light';//(themeMode) ? themeMode : 'light';
      var fonts = {
        base: 'Open Sans'
      }
      // Colors
      var colors = {
        gray: {
          100: '#f6f9fc',
          200: '#e9ecef',
          300: '#dee2e6',
          400: '#ced4da',
          500: '#adb5bd',
          600: '#8898aa',
          700: '#525f7f',
          800: '#32325d',
          900: '#212529'
        },
        theme: {
          'default': '#172b4d',
          'primary': '#5e72e4',
          'secondary': '#f4f5f7',
          'info': '#11cdef',
          'success': '#2dce89',
          'danger': '#f5365c',
          'warning': '#fb6340'
        },
        black: '#12263F',
        white: '#FFFFFF',
        transparent: 'transparent',
      };

      // Methods
      // Chart.js global options
      function chartOptions() {
        // Options
        var options = {
          defaults: {
            global: {
              responsive: true,
              maintainAspectRatio: false,
              defaultColor: (mode == 'dark') ? colors.gray[700] : colors.gray[600],
              defaultFontColor: (mode == 'dark') ? colors.gray[700] : colors.gray[600],
              defaultFontFamily: fonts.base,
              defaultFontSize: 13,
              layout: {
                padding: 0
              },
              legend: {
                display: false,
                position: 'bottom',
                labels: {
                  usePointStyle: true,
                  padding: 16
                }
              },
              elements: {
                point: {
                  radius: 0,
                  backgroundColor: colors.theme['primary']
                },
                line: {
                  tension: .4,
                  borderWidth: 4,
                  borderColor: colors.theme['primary'],
                  backgroundColor: colors.transparent,
                  borderCapStyle: 'rounded'
                },
                rectangle: {
                  backgroundColor: colors.theme['warning']
                },
                arc: {
                  backgroundColor: colors.theme['primary'],
                  borderColor: (mode == 'dark') ? colors.gray[800] : colors.white,
                  borderWidth: 4
                }
              },
              tooltips: {
                enabled: false,
                mode: 'index',
                intersect: false,
                custom: function(model) {
                  // Get tooltip
                  var $tooltip = $('#chart-tooltip');
                  // Create tooltip on first render
                  if (!$tooltip.length) {
                    $tooltip = $('<div id="chart-tooltip" class="popover bs-popover-top" role="tooltip"></div>');
                    // Append to body
                    $('body').append($tooltip);
                  }

                  // Hide if no tooltip
                  if (model.opacity === 0) {
                    $tooltip.css('display', 'none');
                    return;
                  }

                  function getBody(bodyItem) {
                    return bodyItem.lines;
                  }
                  // Fill with content
                  if (model.body) {
                    var titleLines = model.title || [];
                    var bodyLines = model.body.map(getBody);
                    var html = '';

                    // Add arrow
                    html += '<div class="arrow"></div>';
                    // Add header
                    titleLines.forEach(function(title) {
                      html += '<h3 class="popover-header text-center">' + title + '</h3>';
                    });

                    // Add body
                    bodyLines.forEach(function(body, i) {
                      var colors = model.labelColors[i];
                      var styles = 'background-color: ' + colors.backgroundColor;
                      var indicator = '<span class="badge badge-dot"><i class="bg-primary"></i></span>';
                      var align = (bodyLines.length > 1) ? 'justify-content-left' : 'justify-content-center';
                      html += '<div class="popover-body d-flex align-items-center ' + align + '">' + indicator + body + '</div>';
                    });

                    $tooltip.html(html);
                  }

                  // Get tooltip position
                  var $canvas = $(this._chart.canvas);
                  var canvasWidth = $canvas.outerWidth();
                  var canvasHeight = $canvas.outerHeight();
                  var canvasTop = $canvas.offset().top;
                  var canvasLeft = $canvas.offset().left;
                  var tooltipWidth = $tooltip.outerWidth();
                  var tooltipHeight = $tooltip.outerHeight();
                  var top = canvasTop + model.caretY - tooltipHeight - 16;
                  var left = canvasLeft + model.caretX - tooltipWidth / 2;

                  // Display tooltip
                  $tooltip.css({
                    'top': top + 'px',
                    'left': left + 'px',
                    'display': 'block',
                    'z-index': '100'
                  });
                },
                callbacks: {
                  label: function(item, data) {
                    var label = data.datasets[item.datasetIndex].label || '';
                    var yLabel = item.yLabel;
                    var content = '';
                    if (data.datasets.length > 1) {
                      content += '<span class="badge badge-primary mr-auto">' + label + '</span>';
                    }
                    content += '<span class="popover-body-value">' + yLabel + '</span>' ;
                    return content;
                  }
                }
              }
            },
            doughnut: {
              cutoutPercentage: 83,
              tooltips: {
                callbacks: {
                  title: function(item, data) {
                    var title = data.labels[item[0].index];
                    return title;
                  },
                  label: function(item, data) {
                    var value = data.datasets[0].data[item.index];
                    var content = '';
                    content += '<span class="popover-body-value">' + value + '</span>';
                    return content;
                  }
                }
              },
              legendCallback: function(chart) {
                var data = chart.data;
                var content = '';
                data.labels.forEach(function(label, index) {
                  var bgColor = data.datasets[0].backgroundColor[index];
                  content += '<span class="chart-legend-item">';
                  content += '<i class="chart-legend-indicator" style="background-color: ' + bgColor + '"></i>';
                  content += label;
                  content += '</span>';
                });
                return content;
              }
            }
          }
        }

        // yAxes
        Chart.scaleService.updateScaleDefaults('linear', {
          gridLines: {
            borderDash: [2],
            borderDashOffset: [2],
            color: (mode == 'dark') ? colors.gray[900] : colors.gray[300],
            drawBorder: false,
            drawTicks: false,
            lineWidth: 0,
            zeroLineWidth: 0,
            zeroLineColor: (mode == 'dark') ? colors.gray[900] : colors.gray[300],
            zeroLineBorderDash: [2],
            zeroLineBorderDashOffset: [2]
          },
          ticks: {
            beginAtZero: true,
            padding: 10,
            callback: function(value) {
              if (!(value % 10)) {
                return value
              }
            }
          }
        });

        // xAxes
        Chart.scaleService.updateScaleDefaults('category', {
          gridLines: {
            drawBorder: false,
            drawOnChartArea: false,
            drawTicks: false
          },
          ticks: {
            padding: 20
          },
          maxBarThickness: 10
        });

        return options;

      }

      // Parse global options
      function parseOptions(parent, options) {
        for (var item in options) {
          if (typeof options[item] !== 'object') {
            parent[item] = options[item];
          } else {
            parseOptions(parent[item], options[item]);
          }
        }
      }

      // Push options
      function pushOptions(parent, options) {
        for (var item in options) {
          if (Array.isArray(options[item])) {
            options[item].forEach(function(data) {
              parent[item].push(data);
            });
          } else {
            pushOptions(parent[item], options[item]);
          }
        }
      }
      // Pop options
      function popOptions(parent, options) {
        for (var item in options) {
          if (Array.isArray(options[item])) {
            options[item].forEach(function(data) {
              parent[item].pop();
            });
          } else {
            popOptions(parent[item], options[item]);
          }
        }
      }

      // Toggle options
      function toggleOptions(elem) {
        var options = elem.data('add');
        var $target = $(elem.data('target'));
        var $chart = $target.data('chart');

        if (elem.is(':checked')) {

          // Add options
          pushOptions($chart, options);

          // Update chart
          $chart.update();
        } else {

          // Remove options
          popOptions($chart, options);

          // Update chart
          $chart.update();
        }
      }

      // Update options
      function updateOptions(elem) {
        var options = elem.data('update');
        var $target = $(elem.data('target'));
        var $chart = $target.data('chart');

        // Parse options
        parseOptions($chart, options);

        // Toggle ticks
        toggleTicks(elem, $chart);

        // Update chart
        $chart.update();
      }

      // Toggle ticks
      function toggleTicks(elem, $chart) {
        if (elem.data('prefix') !== undefined || elem.data('prefix') !== undefined) {
          var prefix = elem.data('prefix') ? elem.data('prefix') : '';
          var suffix = elem.data('suffix') ? elem.data('suffix') : '';

          // Update ticks
          $chart.options.scales.yAxes[0].ticks.callback = function(value) {
            if (!(value % 10)) {
              return prefix + value + suffix;
            }
          }

          // Update tooltips
          $chart.options.tooltips.callbacks.label = function(item, data) {
            var label = data.datasets[item.datasetIndex].label || '';
            var yLabel = item.yLabel;
            var content = '';

            if (data.datasets.length > 1) {
              content += '<span class="popover-body-label mr-auto">' + label + '</span>';
            }

            content += '<span class="popover-body-value">' + prefix + yLabel + suffix + '</span>';
            return content;
          }

        }
      }

      // Events
      // Parse global options
      if (window.Chart) {
        parseOptions(Chart, chartOptions());
      }

      // Toggle options
      $toggle.on({
        'change': function() {
          var $this = $(this);
          if ($this.is('[data-add]')) {
            toggleOptions($this);
          }
        },
        'click': function() {
          var $this = $(this);
          if ($this.is('[data-update]')) {
            updateOptions($this);
          }
        }
      });
      // Return
      return {
        colors: colors,
        fonts: fonts,
        mode: mode
      };

    })();
  </script>
@endsection