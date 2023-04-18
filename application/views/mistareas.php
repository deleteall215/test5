<section id="main-content">
    <section class="wrapper">

<div class="row">
<?php
 foreach ($tareas as $t) {
?>
<div class="col-md-4 tarea">
<div class="row">
    <strong><?= $t->nombre ?></strong>
</div>
    <div class="row">
        <?= $t->descripcion ?>
    </div>
    <div class="row">
        <?= date('d-m-y',strtotime($t->fecha_final)) ?>
    </div>
    <div class="row">
           <?php
           if($t->archivo!=""){
           ?>
           <a href="<?= base_url().'uploads/'. $t->archivo ?> download ">Descagar</a>
            <?php
            }else{
               echo "sin archivo";
           }
            ?>
    </div>

</div>
     <?php
      }
      ?>

    </section>
</section>
