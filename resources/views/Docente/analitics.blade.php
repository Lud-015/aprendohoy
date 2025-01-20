@extends('FundacionPlantillaUsu.index')


@section('content')
    @forelse ($cursos2 as $cursos)
        @if (auth()->user()->id == $cursos->docente_id)
            <div class="w-full md:w-1/2 xl:w-1/3 p-3">

                {{-- <a href="{{ route('Curso', Crypt::encrypt($cursos->id)) }}" class="block bg-white border rounded shadow p-2"> --}}
                <a href="{{ route('rfc', $cursos->id) }}" class="block bg-white border rounded shadow p-2">
                    <div class="flex flex-row items-center">
                        <div class="flex-shrink pr-4">
                            <div class="rounded p-3 bg-blue-400"><i class="fa fa-bars fa-2x fa-fw fa-inverse"></i>
                            </div>
                        </div>
                        <div class="flex-1 text-right md:text-center">
                            <h3 class="atma text-3xl">{{ $cursos->nombreCurso }} <span class="text-green-500"></span>
                            </h3>
                            <h5 class="alegreya uppercase"></h5>
                            <span class="inline-block mt-2">IR</span>
                        </div>
                    </div>
                </a>
            </div>
        @else
        @endif
    @empty
        <div class="card pb-3 pt-3 col-xl-12">
            <h4>NO TIENES CURSOS ASIGNADOS</h4>
        </div>
    @endforelse
@endsection
