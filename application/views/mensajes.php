    <section id="main-content">
    <section class="wrapper">

                   <div class="row">

                   <button id="btnmensaje" class="btn btn-success btn-md" data-toggle="modal" data-target="#myModal"> Enviar mensaje </button>

                   </div>



                                 <table id="tablamensajes" class="display" style="width: 100%">
                                    <thead>

                                        <th>Nombre</th>
                                        <th>Apellidos</th>
                                        <th>Fecha</th>
                                        <th>ver</th>

                                    </thead>
                                    <tbody>
                                       <?php
                                       foreach ($mensajes as $m) {
                                           $nombreyapellidos=$this->site_model->getNombre($m->id_from);
                                           $nombre=$nombreyapellidos[0]->nombre;
                                           $apellidos=$nombreyapellidos[0]->apellidos;

                                           if($m->is_read==1){
                                              $class="isreadclass";
                                           }
                                        ?>
                                        <tr>
                                            <td><?= $m->nombre ?></td>
                                            <td><?= $m->apellidos ?></td>
                                            <td><?= date('d-m H:i',strtotime($m->created_at)) ?></td>
                                            <td id="vermensaje-<?= $m->id ?>" class="<?= $class ?>" onclick="vermensaje(<?= $m->id ?>,'<?= $nombre ?>',this.id)">ver</td>
                                        </tr>
                                        <?php
                                        }
                                       ?>
                                    </tbody>
                                </table>




                    <div class="modal fade in" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" style="display: none;">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    <h4 class="modal-title" id="myModalLabel">Enviar mensaje</h4>
                                </div>
                                <div class="modal-body">

                                    <form action="" method="post">

                                        <div class="form-group">
                                            <label class="col-sm-2 col-sm-2 control-label">Destisnario</label><br>
                                            <div class="col-sm-10">
                                                <select name="id_to">
                                                    <option class="form-control" value="0 "disabled>Selecciona un usuario</option>
                                                    <?php
                                                    foreach ($usuarios as $c){
                                                        echo  "<option id='user-".$c->id."' value='".$c->token_mensaje."'>".$c->nombre." ".$c->appellido."
                                                    </option>";
                                                    }
                                                    ?>
                                                </select><br>
                                            </div>
                                           </div>

                                          <div class="form-group">
                                            <label class="col-sm-2 col-sm-2 control-label">Mensaje</label><br>
                                            <div class="col-sm-10">
                                                <textarea class="form-control" name="mensaje" cols="6"></textarea>
                                            </div>
                                          </div>

                                           <div class="form-group">
                                            <label class="col-sm-2 col-sm-2 control-label"></label><br>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="submit" name="" value="Enviar">
                                            </div>
                                           </div>

                                      </form>



                                   </div>
                                  <div class="modal-footer"style="margin-top: 25px">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                  </div>
                              </div>
                          </div>
                       </div>






        <div class="modal fade in" id="modalmensaje" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="myModalLabel">Mensaje de</h4>
                    </div>
                    <div class="modal-body">




                    </div>
                    <div class="modal-footer"style="margin-top: 25px">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>





    </section>
    </section>
         <script>
             function vermensaje(id,nombre){
                 console.log(nombre);
                 $.post("http://localhost/test1/Dashboard/getMensaje",{idmensaje: id}).done(function(data){
                     $("#modalmensaje .modal-title").append(nombre);
                   $("#modalmensaje .modal-body").html(data);
                   $("#modalmensaje").modal('show');
                 });
             }
        $(document).ready( function () {
            $('#tablamensajes').DataTable({
                columnDefs: [{
                    targets: [0],
                    orderData: [0, 1]
                }, {
                    targets: [1],
                    orderData: [1, 0]
                }, {
                    targets: [2],
                    orderData: [2, 0]
                }]
            });
        } );
    </script>