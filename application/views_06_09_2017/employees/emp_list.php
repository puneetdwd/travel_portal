<div class="list-group">
    <li class="list-group-item list-group-header">
        <span class="badge"><?php echo count($emp_list); ?></span><b>Employees List</b>
    </li>
    <?php foreach($emp_list as $list) { ?>
    <a onclick="delete_employee('<?php echo $list['id']; ?>')" class="list-group-item basic-alert">
        <?php echo $list['first_name']." ".$list['last_name']; ?>
        <span class="fa fa-times" style="float: right"></span>
    </a>
    <?php } ?>
</div>