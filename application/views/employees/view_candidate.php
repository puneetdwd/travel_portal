<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            Candidates
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>">Home</a>
            </li>
            <li class="active">Candidates</li>
        </ol>
        
    </div>
    <!-- END PAGE HEADER-->
    
    <!-- BEGIN PAGE CONTENT-->
    <div class="row">
        <div class="col-md-12">
            
            <div class="portlet light bordered review-timesheet-form-portlet">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-reorder"></i> Filter Form
                    </div>
                </div>
            
                <div class="portlet-body form">
                    <form role="form" class="validate-form" method="post">
                        <div class="form-body">
                            <div class="alert alert-danger display-hide">
                                <button class="close" data-close="alert"></button>
                                You have some form errors. Please check below.
                            </div>

                            <?php if($this->session->flashdata('error')) {?>
                                <div class="alert alert-danger">
                                   <i class="fa fa-ban"></i>
                                   <?php echo $this->session->flashdata('error');?>
                                </div>
                            <?php } else if($this->session->flashdata('success')) { ?>
                                <div class="alert alert-success">
                                    <i class="fa fa-check"></i>
                                   <?php echo $this->session->flashdata('success');?>
                                </div>
                            <?php } ?>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Date Range</label>
                                        <div class="input-group date-picker input-daterange" data-date-format="yyyy-mm-dd">
                                            <input type="text" class=" form-control" name="start_range" 
                                            value="<?php echo $this->input->post('start_range'); ?>">
                                            <span class="input-group-addon">
                                            to </span>
                                            <input type="text" class=" form-control" name="end_range"
                                            value="<?php echo $this->input->post('end_range'); ?>">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Candidate</label>
                                        <select name="candidate_id" class="form-control select2me"
                                        data-placeholder="Select Candidate">
                                            <option></option>
                                            <?php foreach($candidate_list as $candi) { ?>
                                                <option value="<?php echo $candi['id']; ?>"
                                                    <?php if(($this->input->post('candidate_id') == $candi['id'])) { ?> selected="selected" <?php } ?> >
                                                    <?php echo $candi['first_name'].' '.$candi['last_name']; ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Status</label>
                                        <select name="status" class="form-control select2me"
                                        data-placeholder="Select Status">
                                            <option></option>
                                            <option value="Pending" <?php if(($this->input->post('status') == 'Pending')) { ?> selected="selected" <?php } ?> >
                                                In Queue
                                            </option>
                                            <option value="Selected" <?php if(($this->input->post('status') == 'Selected')) { ?> selected="selected" <?php } ?> >
                                                Offered
                                            </option>
                                            <option value="Discarded" <?php if(($this->input->post('status') == 'Discarded')) { ?> selected="selected" <?php } ?> >
                                               Discarded
                                            </option>
                                            <option value="Rejected" <?php if(($this->input->post('status') == 'Rejected')) { ?> selected="selected" <?php } ?> >
                                                Rejected
                                            </option>
                                            
                                        </select>
                                    </div>
                                </div>

                                
                            </div>
                        </div>
                        <div class="form-actions">
                            <button class="btn green" type="submit">Submit</button>
                            <a href="<?php echo base_url(); ?>" class="btn default">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
            <?php if(empty($summary) && empty($candidates)){?>
                <div class="portlet-body">
                    <p class="text-center">No Record Found  </p>
                </div>
            <?php } else { ?>
            <div class="actions" style="margin-top:15px;margin-right:50px; float:right">
                <form action="<?php echo base_url()."employees/view_candidates/"?>" method="post" role="form">
                    <input type="hidden" name="start_range" value="<?php echo $this->input->post('start_range'); ?>" />
                    <input type="hidden" name="end_range" value="<?php echo $this->input->post('end_range'); ?>" />
                    <input type="hidden" name="candidate_id" value="<?php echo $this->input->post('candidate_id'); ?>" />
                    <input type="hidden" name="status" value="<?php echo $this->input->post('status'); ?>" />
                    <button class="btn grey-cascade btn-sm" type="submit" name="download_pdf" value="pdf">
                        <i class="fa fa-download"></i> Download as PDF
                    </button>
                </form>
            </div>
            <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption font-green-sharp">
                                <i class="icon-speech font-green-sharp"></i>
                                <span class="caption-subject bold uppercase"> Summary  </span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="row list-separated profile-stat">
                                <div style="margin-left:80px" class="col-md-2 col-sm-4 col-xs-6">
                                    <div class="uppercase profile-stat-title"> <?php echo $summary['total'] ? $summary['total'] : '0';?> </div>
                                    <div class="uppercase profile-stat-text"> Total </div>
                                </div>
                                <div class="col-md-2 col-sm-4 col-xs-6">
                                    <div class="uppercase profile-stat-title"> <?php echo $summary['selected'] ? $summary['selected'] : '0'; ?> </div>
                                    <div class="uppercase profile-stat-text"> Offered </div>
                                </div>
                                <div class="col-md-2 col-sm-4 col-xs-6">
                                    <div class="uppercase profile-stat-title"> <?php echo $summary['pending'] ? $summary['pending'] : '0';?> </div>
                                    <div class="uppercase profile-stat-text"> In Queue </div>
                                </div>
                                <div class="col-md-2 col-sm-4 col-xs-6">
                                    <div class="uppercase profile-stat-title"> <?php echo $summary['rejected'] ? $summary['rejected'] : '0'; ?> </div>
                                    <div class="uppercase profile-stat-text"> Rejected </div>
                                </div>
                                <div class="col-md-2 col-sm-4 col-xs-6">
                                    <div class="uppercase profile-stat-title"> <?php echo $summary['discarded'] ? $summary['discarded'] : '0';?> </div>
                                    <div class="uppercase profile-stat-text"> Discarded </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <!-- END Portlet PORTLET-->
                </div>
                
            </div>
            
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-reorder"></i>Transactions
                    </div>
<!--                    <div class="actions">
                        <a class="btn grey-cascade" href="<?php echo base_url(); ?>">
                            <i class="fa fa-plus"></i> Add New User
                        </a>
                    </div>-->
                </div>
                <div class="portlet-body">
                    
                    <?php if(empty($candidates)) { ?>
                        <p class="text-center">No Candidate exist yet.</p>
                    <?php } else { ?>
                    
                        <div id="legends" style="float:right">
                            <p> <b> For Delete :</b>
                                <a class="btn default btn-xs red">
                                    <i class="fa fa-trash-o"></i> 
                                </a>
                                <b> For Offer :</b>
                                <a class="btn btn-xs btn-success">
                                    <i class="fa fa-opera"></i>
                                </a>
                                <b> For Create Employee :</b>
                                <a class="btn btn-xs btn-primary">
                                    <i class="fa fa-user"></i> 
                                </a> 
                                <b> For Discard :</b>
                                <a class="btn btn-xs purple">
                                    <i class="fa fa-ban"></i>
                                </a>
                                <b> For Reject :</b>
                                <a class="btn btn-xs btn-warning">
                                    <i class="fa fa-close"></i>
                                </a>
                            </p>
                        </div>
                        <table class="table table-custom" id="make-data-table">
                            <thead>
                                <tr>
                                    <th>Ref. Code</th>
                                    <th>Contact Date</th>
                                    <th>Candidate Name</th>
                                    <th>Referred By</th>
                                    <th>Candidate Phone</th>
                                    <th>Candidate Email</th>
                                    <th>Status</th>
                                    <th>PDF</th>
                                    <th class="no_sort" style="width:150px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($candidates as $candidate) { ?>
                                    <?php 
                                         $now = time(); // or your date as well
                                         $your_date = strtotime($candidate['created']);
                                         $datediff = $now - $your_date;
                                         $diff = floor($datediff/(60*60*24));
                                    ?>
                                    <tr>
                                       <?php if($diff > 15 && $candidate['status'] === 'Pending') { ?>
                                                <td><font color="red"><?php echo $candidate['ref_code']; ?></font></td>
                                                <td><font color="red"><?php echo date('jS M, Y', strtotime($candidate['created'])); ?></font></</td>
                                                <td><font color="red"><?php echo $candidate['first_name']." ".$candidate['last_name']; ?></font></</td>
                                                <td><font color="red"><?php 
                                                if(!empty($candidate['reffered_by'])){ echo $candidate['reffered_by_name']."<br>(".$candidate['reffered_by'].")";} else{ echo 'NA'; }  ?></font></</td>
                                                <td><font color="red"><?php echo $candidate['phone']."<br>".$candidate['emergency_phone']; ?></font></</td>
                                                <td><font color="red"><?php echo $candidate['email']; ?></font></</td>
                                                <td>
                                                    <?php if($candidate['status'] === 'Pending') { ?>
                                                        <span class="label label-info"> 
                                                            <i class="fa fa-male"></i> In Queue
                                                        </span>
                                                    <?php } else if($candidate['status'] === 'Selected') { ?>
                                                        <span class="label label-success"> 
                                                            <i class="fa fa-thumbs-o-up"></i> Offered 
                                                        </span>
                                                    <?php } else if($candidate['status'] === 'Offered') { ?>
                                                        <span class="label label-success"> 
                                                            <i class="fa fa-thumbs-o-up"></i> Offered 
                                                        </span>
                                                    <?php } else if($candidate['status'] === 'Rejected') { ?>
                                                        <span class="label label-warning" data-toggle="tooltip"> 
                                                            <i class="fa fa-thumbs-o-down"></i> <?php echo $candidate['status']; ?> 
                                                        </span>
                                                    <?php } else if($candidate['status'] === 'Discarded') { ?>
                                                        <span class="label label-danger" data-toggle="tooltip"> 
                                                            <i class="fa fa-thumbs-o-down"></i> <?php echo $candidate['status']; ?> 
                                                        </span>
                                                    <?php }  ?> 
                                                </td>
                                                <td><a class="btn-link"  href="<?php echo base_url().'assets/candidate-employment-form/'.explode('@',$candidate['email'])[0].".pdf"; ?>" 
                                                       target="_blank">
                                                       <i class="fa fa-file"></i>   
                                                    </a>
                                                </td>
                                                <td nowrap>
                                                         <?php if($candidate['status'] == 'Pending'){ ?>
                                                            <a class="btn default btn-xs red" onclick="return confirm('You really want to delete this record ?');"
                                                                href="<?php echo base_url()."candidate/del_candidate/".$candidate['id'];?>">
                                                                <i class="fa fa-trash-o"></i> 
                                                            </a>
                                                            <a class="btn btn-xs btn-success " data-confirm="Are you sure you want to offer?"
                                                                href="<?php echo base_url()."candidate/change_status/".$candidate['id'].'/Offered' ;?> ">
                                                                <i class="fa fa-opera"></i>
                                                            </a>
                                                            <a class="btn btn-xs purple" data-confirm="Are you sure you want to approve this request?"
                                                                href="<?php echo base_url()."candidate/change_status/".$candidate['id'].'/Discarded' ;?>">
                                                                <i class="fa fa-ban"></i> 
                                                            </a>
                                                            
                                                            <a class="btn btn-xs btn-warning " data-confirm="Are you sure you want to approve this request?"
                                                                href="<?php echo base_url()."candidate/change_status/".$candidate['id'].'/Rejected' ;?>">
                                                                <i class="fa fa-close"></i> 
                                                            </a>
                                                            <a class="btn btn-xs btn-primary " data-confirm="Are you sure you want to create employee?"
                                                                href="<?php echo base_url()."employees/add/?ref_code=".$candidate['ref_code'] ;?> ">
                                                                <i class="fa fa-user"></i> 
                                                            </a>
                                                        <?php } ?>
                                                </td>
                                            </tr>
                                        <?php } else {?>
                                        
                                            <td><?php echo $candidate['ref_code']; ?></td>
                                            <td><?php echo date('jS M, Y', strtotime($candidate['created'])); ?></td>
                                            <td><?php echo $candidate['first_name']." ".$candidate['last_name']; ?></td>
                                            <td><?php 
                                            if(!empty($candidate['reffered_by'])){ echo $candidate['reffered_by_name']."<br>(".$candidate['reffered_by'].")";} else{ echo 'NA'; }  ?></td>
                                            <td><?php echo $candidate['phone']."<br>".$candidate['emergency_phone']; ?></td>
                                            <td><?php echo $candidate['email']; ?></td>
                                            <td>
                                                <?php if($candidate['status'] === 'Pending') { ?>
                                                    <span class="label label-info"> 
                                                        <i class="fa fa-male"></i> In Queue
                                                    </span>
                                                <?php } else if($candidate['status'] === 'Selected') { ?>
                                                    <span class="label label-success"> 
                                                        <i class="fa fa-thumbs-o-up"></i> Offered 
                                                    </span>
                                                <?php } else if($candidate['status'] === 'Offered') { ?>
                                                        <span class="label label-success"> 
                                                            <i class="fa fa-thumbs-o-up"></i> Offered 
                                                        </span>
                                                <?php } else if($candidate['status'] === 'Rejected') { ?>
                                                    <span class="label label-warning" data-toggle="tooltip"> 
                                                        <i class="fa fa-thumbs-o-down"></i> <?php echo $candidate['status']; ?> 
                                                    </span>
                                                <?php } else if($candidate['status'] === 'Discarded') { ?>
                                                    <span class="label label-danger" data-toggle="tooltip"> 
                                                        <i class="fa fa-thumbs-o-down"></i> <?php echo $candidate['status']; ?> 
                                                    </span>
                                                <?php }  ?> 
                                            </td>
                                            <td><a class="btn-link"  href="<?php echo base_url().'assets/candidate-employment-form/'.explode('@',$candidate['email'])[0].".pdf"; ?>" 
                                                   target="_blank">
                                              <i class="fa fa-file"></i>   
                                            </a></td>
                                            <td nowrap>
                                             <?php if($candidate['status'] == 'Pending'){ ?>
                                                    <a class="btn default btn-xs red" data-confirm="Are you sure you want to delete this User?"
                                                        href="<?php echo base_url()."candidate/del_candidate/".$candidate['id'];?>">
                                                        <i class="fa fa-trash-o"></i> 
                                                    </a>
                                                    <a class="btn btn-xs btn-success " data-confirm="Are you sure you want to offer?"
                                                        href="<?php echo base_url()."candidate/change_status/".$candidate['id'].'/Offered' ;?> ">
                                                        <i class="fa fa-opera"></i>
                                                    </a>
                                                    <a class="btn btn-xs purple" data-confirm="Are you sure you want to approve this request?"
                                                        href="<?php echo base_url()."candidate/change_status/".$candidate['id'].'/Discarded' ;?>">
                                                        <i class="fa fa-ban"></i> 
                                                    </a>
                                                    
                                                    <a class="btn btn-xs btn-warning " data-confirm="Are you sure you want to approve this request?"
                                                        href="<?php echo base_url()."candidate/change_status/".$candidate['id'].'/Rejected' ;?>">
                                                        <i class="fa fa-close"></i> 
                                                    </a>
                                                    <a class="btn btn-xs btn-primary " data-confirm="Are you sure you want to create employee?"
                                                        href="<?php echo base_url()."employees/add/?ref_code=".$candidate['ref_code'] ;?> ">
                                                        <i class="fa fa-user"></i> 
                                                    </a>
                                                <?php } if(empty($candidate['emp_id']) && $candidate['status'] == 'Selected' || $candidate['status'] == 'Offered'   ){?>
                                                    <a class="btn btn-xs btn-primary " data-confirm="Are you sure you want to create employee?"
                                                        href="<?php echo base_url()."employees/add/?ref_code=".$candidate['ref_code'] ;?> ">
                                                        <i class="fa fa-user"></i> Create Employee
                                                    </a>
                                                <?php }  ?> 
                                            </td>
                                        </tr>
                                <?php }} ?>
                            </tbody>
                        </table>
                        
                    <?php } ?>
                    
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>