@extends('FundacionPlantillaUsu.index')

@section('content')

<!-- CDN: Year Calendar -->
<link rel="stylesheet" href="https://unpkg.com/js-year-calendar/dist/js-year-calendar.min.css">
<script src="https://unpkg.com/js-year-calendar/dist/js-year-calendar.min.js"></script>
<script src="{{ asset('assets/js/js-year-calendar.es.js') }}"></script>

<!-- Estilos personalizados -->
<style>
    #calendar {
        max-width: 1000px;
        margin: 2rem auto;
    }

    .event-tooltip {
        position: absolute;
        background-color: rgba(0, 0, 0, 0.85);
        color: #fff;
        padding: 10px 12px;
        border-radius: 6px;
        font-size: 0.875rem;
        z-index: 1050;
        pointer-events: none;
        display: none;
        max-width: 250px;
    }

    .event-tooltip-content {
        margin-bottom: 6px;
        padding: 4px 6px;
        border-left: 4px solid #0d6efd;
        background-color: #f8f9fa;
        color: #212529;
        border-radius: 4px;
    }

    .event-name {
        font-weight: 600;
    }

    .event-description {
        font-size: 0.75rem;
    }
</style>

<!-- Filtros -->
<div class="container my-4">
    <h2 class="h5 fw-semibold mb-3">Filtrar eventos</h2>
    <div class="d-flex flex-wrap gap-3">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="tarea-checkbox" checked>
            <label class="form-check-label" for="tarea-checkbox">Tareas</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="cuestionario-checkbox" checked>
            <label class="form-check-label" for="cuestionario-checkbox">Cuestionarios</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="foro-checkbox" checked>
            <label class="form-check-label" for="foro-checkbox">Foros</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="evaluacion-checkbox" checked>
            <label class="form-check-label" for="evaluacion-checkbox">Evaluaciones</label>
        </div>
    </div>
</div>

<!-- Calendario -->
<div id="calendar"></div>
<div id="tooltip" class="event-tooltip"></div>

<!-- Script -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const actividades = @json($actividades);
        const cursos = @json($cursos->pluck('nombreCurso', 'id')->toArray());

        const tooltip = document.getElementById('tooltip');

        const getEvents = () => {
            let events = [];
            const tiposActividad = {
                'tarea': document.getElementById('tarea-checkbox').checked,
                'cuestionario': document.getElementById('cuestionario-checkbox').checked,
                'foro': document.getElementById('foro-checkbox').checked,
                'evaluacion': document.getElementById('evaluacion-checkbox').checked
            };

            actividades.forEach(actividad => {
                const tipoSlug = actividad.tipo_actividad.slug;
                if (tiposActividad[tipoSlug]) {
                    events.push({
                        startDate: new Date(actividad.fecha_limite),
                        endDate: new Date(actividad.fecha_limite),
                        name: actividad.titulo,
                        description: `${actividad.subtema.tema.titulo} - ${cursos[actividad.subtema.tema.curso_id]}`,
                        type: actividad.tipo_actividad.nombre
                    });
                }
            });

            return events;
        };

        const calendar = new Calendar('#calendar', {
            enableRangeSelection: false,
            dataSource: getEvents(),
            style: 'background',
            displayWeekNumber: true,
            weekStart: 1,
            language: 'es',
            mouseOnDay: (e) => {
                if (e.events.length > 0) {
                    let content = '';
                    e.events.forEach(ev => {
                        content += `
                            <div class="event-tooltip-content">
                                <div class="event-name">${ev.name} (${ev.type})</div>
                                <div class="event-description">${ev.description}</div>
                            </div>`;
                    });
                    tooltip.innerHTML = content;
                    tooltip.style.display = 'block';

                    e.element.addEventListener('mousemove', moveTooltip);
                }
            },
            mouseOutDay: () => {
                tooltip.style.display = 'none';
            }
        });

        const moveTooltip = (evt) => {
            tooltip.style.left = (evt.pageX + 15) + 'px';
            tooltip.style.top = (evt.pageY + 15) + 'px';
        };

        // Event listeners for checkboxes
        ['tarea', 'cuestionario', 'foro', 'evaluacion'].forEach(tipo => {
            document.getElementById(`${tipo}-checkbox`).addEventListener('change', () => {
                calendar.setDataSource(getEvents());
            });
        });
    });
</script>

@endsection
