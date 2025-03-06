@extends('FundacionPlantillaUsu.index')



@section('content')
    <link rel="stylesheet" href="https://unpkg.com/js-year-calendar/dist/js-year-calendar.min.css">
    <link rel="stylesheet" href="https://unpkg.com/js-year-calendar/dist/js-year-calendar.min.css">
    <style>
        #calendar {
            max-width: 900px;
            margin: 40px auto;
        }

        .event-tooltip {
            position: absolute;
            background: rgba(0, 0, 0, 0.7);
            color: #fff;
            padding: 10px;
            border-radius: 5px;
            z-index: 1000;
            pointer-events: none;
            display: none;
        }
    </style>
    <div class="">
        <input type="checkbox" id="tasks-checkbox" checked> Tareas
        <br>
        <input type="checkbox" id="evaluations-checkbox" checked> Evaluaciones
        <br>
        <input type="checkbox" id="forums-checkbox" checked> Foros
    </div>

    <div id="calendar"></div>
    <div id="tooltip" style="display:none; position:absolute;"></div>


    <script src="https://unpkg.com/js-year-calendar/dist/js-year-calendar.min.js"></script>
    <script src="{{ asset('assets/js/js-year-calendar.es.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var tasks = @json($tareas);
            var evaluations = @json($evaluaciones);
            var forums = @json($foros);

            var cursos = @json($cursos->pluck('nombreCurso', 'id')->toArray());
            console.log(cursos);

            function getEvents() {
                var events = [];

                if (document.getElementById('tasks-checkbox').checked) {
                    events = events.concat(tasks.map(function(task) {
                        return {
                            startDate:  new Date(task.fecha_vencimiento),
                            endDate: new Date(task.fecha_vencimiento),
                            name: task.titulo_tarea ,
                            description: cursos[task.cursos_id],
                            type: 'Tarea'
                        };
                    }));
                }

                if (document.getElementById('evaluations-checkbox').checked) {
                    events = events.concat(evaluations.map(function(evaluation) {
                        return {
                            startDate:  new Date(evaluation.fecha_vencimiento),
                            endDate: new Date(evaluation.fecha_vencimiento),
                            name: evaluation.titulo_evaluacion,
                            description: cursos[evaluation.cursos_id],
                            type: 'Evaluación'
                        };
                    }));
                }

                if (document.getElementById('forums-checkbox').checked) {
                    events = events.concat(forums.map(function(forum) {
                        return {
                            startDate: new Date(forum.fechaFin),
                            endDate: new Date(forum.fechaFin),
                            name: forum.nombreForo,
                            description: cursos[forum.cursos_id],
                            type: 'Foro'
                        };
                    }));
                }

                return events;
            }

            var tooltip = document.getElementById('tooltip');

            var calendar = new Calendar('#calendar', {
                enableRangeSelection: true,
                dataSource: getEvents(),
                style: 'background',
                displayWeekNumber: true,
                weekStart: 1, // Iniciar semana el lunes
                language: 'es', // Establecer idioma a español
                mouseOnDay: function(e) {
                    if (e.events.length > 0) {
                        var content = '';

                        for (var i in e.events) {
                            content += '<div style="background-color: white;" class="event-tooltip-content">' +
                                '<div class="event-name">' + e.events[i].name + ' ' + e.events[i].type  + '</div>' +
                                '<div class="event-description">' + e.events[i].description + '</div>' +
                                '</div>';
                        }

                        tooltip.innerHTML = content;
                        tooltip.style.display = 'block';

                        e.element.addEventListener('mousemove', function(evt) {
                            tooltip.style.left = evt.pageX + 10 + 'px';
                            tooltip.style.top = evt.pageY + 10 + 'px';
                        });
                    }
                },
                mouseOutDay: function(e) {
                    tooltip.style.display = 'none';
                }
            });

            function updateCalendar() {
                calendar.setDataSource(getEvents());
            }

            document.getElementById('tasks-checkbox').addEventListener('change', updateCalendar);
            document.getElementById('evaluations-checkbox').addEventListener('change', updateCalendar);
            document.getElementById('forums-checkbox').addEventListener('change', updateCalendar);
        });
    </script>
@endsection
