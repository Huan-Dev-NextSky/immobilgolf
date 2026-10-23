<?php foreach($expert_module_all as $key=>$row):?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h4 class="panel-title">
            <a data-toggle="collapse" data-parent="#accordionThree" href="#collapse<?php echo $key;?>" aria-expanded="false" class="collapsed">
              <?php echo $row->question; ?>                                        
            </a>
        </h4>
    </div>
    <div id="collapse<?php echo $key;?>" class="panel-collapse collapse <?php echo ($key==0) ? 'in' : '' ;?>" aria-expanded="false" style="height: 0px;">
        <div class="panel-body">
            <?php echo $row->answer; ?>                                    
        </div>
    </div>
</div>
<?php endforeach; ?>
<div class="pagination news">
    <?php echo $expert_pagination; ?>
</div>