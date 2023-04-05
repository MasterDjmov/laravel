 <div class="container mt-3 d-block">
                          <div class="row">
                            <!--primera Card-->
                            <div class="ml-1">
                              <div class="card shadow-lg bg-suplente">
                                <div class="card-title mt-4 d-flex justify-content-center">
                                  <h5 class="mb-0">({{$o->idNodo}})-Docente: {{strtoupper($o->Nombres)}}</h5>
                                </div>
                                <div class="card-body">
                                  <p class="mb-0">Cargo: 
                                    <select name="Asignatura">
                                    @foreach ($CargosInicial as $c)
                                      <option value='{{$c->idAsignatura}}'>{{$c->Descripcion}}</option>
                                    @endforeach
                                    </select>
                                  </p>
                                  <p class="mb-0">Sit.Rev:
                                  <select name="SituacionDeRevista">
                                    @foreach ($SituacionDeRevista as $sr)
                                      <option value='{{$sr->idSituacionRevista}}'>{{$sr->Descripcion}}</option>
                                    @endforeach
                                    </select>
                                  </p>
                                  <p class="mb-0">Licencia: XXXX</p>
                                  <p class="mb-0">Division/Año: 
                                  <select name="Curso">
                                    <option value="">1</option>
                                    <option value="">2</option>
                                    <option value="">3...</option>
                                  <select>
                                   - 
                                   <select name="Division">
                                    <option value="">1</option>
                                    <option value="">A</option>
                                    <option value="">I...</option>
                                  <select>
                                   </p>
                                  <p class="mb-0">Horas: <input type="number" name="cant_horas" style="width:50px" value="{{rand(1,40)}}"></p>
                                </div>
                                <div class="card-footer">
                                  <a type="button" href="#" class="btn mx-1" data-toggle="tooltip" data-placement="top" title="Licencia">
                                    <span class="material-symbols-outlined pt-1">medical_services</span>
                                  </a>
                                  <a href="#" class="btn mx-1 " data-toggle="tooltip" data-placement="top" title="Agregar Docente">
                                    <span class="material-symbols-outlined pt-1" >group_add</span>
                                  </a>
                                  <a href="#" class="btn mx-1">
                                    <span class="material-symbols-outlined pt-1" data-toggle="tooltip" data-placement="top" title="Traslado/Afectación">transfer_within_a_station</span>
                                  </a>
                                  <a href="#" class="btn mx-1">
                                    <span class="material-symbols-outlined pt-1" data-toggle="tooltip" data-placement="top" title="Confirmar">done</span>
                                  </a>
                                  <a href="{{route('agregaNodo',$o->idNodo)}}" class="btn mx-1">
                                    <span class="material-symbols-outlined pt-1" data-toggle="tooltip" data-placement="top" title="Vincular">compare_arrows</span>
                                  </a>
                                </div>
                              </div>
                            </div>
                            <!--Fin primera Card-->
                            <!--Flechita-->
                            @if($o->PosicionSiguiente != "")
                            @php
                              //traigo los nodos
                              $infoNodoSiguiente=DB::table('tb_nodos')
                              ->leftjoin('tb_agentes', 'tb_agentes.idAgente', '=', 'tb_nodos.Agente')
                              ->where('tb_nodos.idNodo',$o->PosicionSiguiente)
                              ->select('*')
                              ->get();
                            @endphp
                            <div class="d-flex align-self-center ml-2 mb-4">
                              <div class="align-items-center st0"></div>
                              <div class="align-items-center st2"></div>
                            </div>

                            <!--segunda Card-->
                            @foreach ($infoNodoSiguiente as $sig)
                              <div class="ml-1">
                                <div class="card shadow-lg bg-suplente">
                                  <div class="card-title mt-4 d-flex justify-content-center">
                                    <h5 class="mb-0">({{$sig->idNodo}})-Docente: {{strtoupper($sig->Nombres)}}</h5>
                                  </div>
                                  <div class="card-body">
                                    <p class="mb-0">Cargo: 
                                      <select name="Asignatura">
                                      @foreach ($CargosInicial as $c)
                                        <option value='{{$c->idAsignatura}}'>{{$c->Descripcion}}</option>
                                      @endforeach
                                      </select>
                                    </p>
                                    <p class="mb-0">Sit.Rev:
                                    <select name="SituacionDeRevista">
                                      @foreach ($SituacionDeRevista as $sr)
                                        <option value='{{$sr->idSituacionRevista}}'>{{$sr->Descripcion}}</option>
                                      @endforeach
                                      </select>
                                    </p>
                                    <p class="mb-0">Licencia: XXXX</p>
                                    <p class="mb-0">Division/Año: 
                                    <select name="Curso">
                                      <option value="">1</option>
                                      <option value="">2</option>
                                      <option value="">3...</option>
                                    <select>
                                    - 
                                    <select name="Division">
                                      <option value="">1</option>
                                      <option value="">A</option>
                                      <option value="">I...</option>
                                    <select>
                                    </p>
                                    <p class="mb-0">Horas: <input type="number" name="cant_horas" style="width:50px" value="{{rand(1,40)}}"></p>
                                  </div>
                                  <div class="card-footer">
                                  <a type="button" href="#" class="btn mx-1" data-toggle="tooltip" data-placement="top" title="Retornar">
                                      <span class="material-symbols-outlined pt-1">swipe_left</span>
                                    </a>
                                    <a type="button" href="#" class="btn mx-1" data-toggle="tooltip" data-placement="top" title="Licencia">
                                      <span class="material-symbols-outlined pt-1">medical_services</span>
                                    </a>
                                    <a href="#" class="btn mx-1 " data-toggle="tooltip" data-placement="top" title="Agregar Docente">
                                      <form action="/agregarDatoANodo" method="POST" class="ConfirmarAgregarAgenteANodo">
                                        @csrf
                                        <input type="hidden" name="idNodo" value="{{$sig->idNodo}}">
                                        <input type="text" name="idAgente" style="width:100px">
                                        <button type="submit" class="btn btn-success">+</button>
                                      </form>
                                      <span class="material-symbols-outlined pt-1" >group_add</span>
                                    </a>
                                    <a href="#" class="btn mx-1">
                                      <span class="material-symbols-outlined pt-1" data-toggle="tooltip" data-placement="top" title="Traslado/Afectación">transfer_within_a_station</span>
                                    </a>
                                    <a href="#" class="btn mx-1">
                                      <span class="material-symbols-outlined pt-1" data-toggle="tooltip" data-placement="top" title="Confirmar">done</span>
                                    </a>
                                    <a href="{{route('agregaNodo',$sig->idNodo)}}" class="btn mx-1">
                                      <span class="material-symbols-outlined pt-1" data-toggle="tooltip" data-placement="top" title="Vincular">compare_arrows</span>
                                    </a>
                                  </div>
                                  
                                  
                                </div>
                              </div>
                            @endforeach
                            <!--Fin segunda Card-->
                            @endif
                          </div>
                      </div>