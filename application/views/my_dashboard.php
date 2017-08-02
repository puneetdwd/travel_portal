<style>
    .dept-portlet .progress {
        height:20px;
    }
    .progress {
        height:10px;
        margin-top:10px;
        margin-bottom:10px;
    }
    .progress-marker{
        position:absolute;
        margin-top:-10px;
        z-index:1;
        height:30px;
        width:2px;
    }
    .progress-success {
        background-color:#5cb85c !important;
    }
    .progress-danger {
        background-color:#ed6b75 !important;
    }
    .portlet-indicator {
        float:right;
    }
    .portlet-indicator i {
        line-height: normal !important;
        font-size: 32px;
    }
    .text-success {
        color: #5cb85c !important;
    }
    .progress-bar-success {
        background-color: #5cb85c;
    }
    .profile-stat-title {
        font-size: 14px;
        white-space: nowrap;
        color: #337ab7;
    }
    .profile-stat-text {
        color: #7f90a4;
    }
    .text-danger {
        color: #ed6b75 !important;
    }
    .portlet-body {
        position: relative;
    }
    
    .progress-bar{
        -webkit-transition: width 1.5s ease-in-out;
        transition: width 1.5s ease-in-out;
    }
    
    .progress-bar-vertical {
        width: 100%;
        min-height: 100px;
        //display: flex;
        align-items: flex-end;
        margin-right: 20px;
        float: left;
    }
    
    .progress-bar-vertical .progress-bar {
        width: 100%;
    }

    .number small {
        color: #005982;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
    }
    .number h3 {
        font-size: 22px;
        font-weight: 400;
        margin: 0 0 2px;
        padding: 0;
        color: #f26e22;
    }
    
    .progress-info .status {
        color: #aab5bc;
        font-size: 11px;
        font-weight: 600;
        margin-top: 5px;
        text-transform: uppercase;
    }
    .progress-info .status .status-title {
        display: inline-block;
        float: left;
    }
    .progress-info .status .status-number {
        display: inline-block;
        float: right;
    }
    .market-stats {
        font-size:16px;
        color:#666;
    }
    .market-stats .market-stats-figure {
        font-size:24px;
    }
    
    .progress.lg-progress {
        height:30px;
    }
    .progress.lg-progress .progress-bar > span {
        line-height:30px;
    }
    .legend-color-box {
        display: inline-block;
        height: 10px;
        width: 10px;
    }
    .legend-box {
        margin-right:10px;
    }
    .legend-color-box.dvs {
        background-color: #005982;
    }
    .legend-color-box.dps {
        background-color: #f26e22;
    }
    .legend-color-box.custom {
        background-color: #1BBC9B;
    }
    .legend-color-box.others {
        background-color: #C8D046;
    }
    .legend-color-box.y2015 {
        background-color: #B0B0B0;
    }
    .legend-color-box.y2016 {
        background-color: #0D4F8B;
    }
    .checkbox-inline, .radio-inline {
        padding-left:0px;
    }
</style>

<?php $currency = $configuration['currency']; 
global $conversion;
$conversion = $configuration['conversion']; ?>

<?php 
    function conversion($money, $currency) {
        global $conversion;
        if($currency === 'Dollar') {
            $money = $money/$conversion;
        }
        
        return convert_money($money);
    }
?>

<?php $symbol_class = ($currency === 'Dollar') ? "fa-dollar" : "fa-rupee"; ?>


<link href="<?php echo base_url(); ?>assets/new/global/plugins/morris/morris.css" rel="stylesheet" type="text/css" />
<style>
.display{
    margin-bottom: 0px !important;
}
</style>
<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            Insights
        </h1>
        
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>">Home</a>
            </li>
            <li class="active">Revenue Dashboard</li>
        </ol>
        
    </div>
    
    <!-- Section for showing configuration -->
    <div class="row">
        <?php if($this->session->flashdata('error')) {?>
            <div class="alert alert-danger">
               <i class="fa fa-times"></i>
               <?php echo $this->session->flashdata('error');?>
            </div>
        <?php } else if($this->session->flashdata('success')) { ?>
            <div class="alert alert-success">
                <i class="fa fa-check"></i>
               <?php echo $this->session->flashdata('success');?>
            </div>
        <?php } ?>
        <div class="col-md-12">
            <div class="portlet light bordered" style="padding-top: 5px; padding-bottom: 5px; margin-bottom: 10px;">

                <div class="portlet-body form">
                    <div class="row">
                        <div class="col-md-3 text-left">
                            <div class="">
                                <label class="control-label"><b>Currency:</b></label>
                                <label class="radio-inline">
                                    <input type="radio" class="currency-radio" name="currency" value="Rupee" <?php if($configuration['currency'] == 'Rupee') { ?>checked<?php } ?>> Rupee
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" class="currency-radio" name="currency" value="Dollar" <?php if($configuration['currency'] == 'Dollar') { ?>checked<?php } ?>> Dollar 
                                </label>
                            </div>
                        </div>
                        
                        <div class="col-md-3 text-center">
                            <div class="">
                                <label class="control-label"><b>Conversion:</b></label>
                                <p id="ri-sampling-plan" class="form-control-static">
                                    <?php echo $configuration['conversion']; ?>
                                </p>
                            </div>
                        </div>
                        
                        <div class="col-md-3 text-center">
                            <div class="">
                                <label class="control-label"><b>Target :</b></label>
                                <p id="ri-completed" class="form-control-static">
                                   <small><i class="fa <?php echo $symbol_class; ?>"></i></small>
                                   <?php echo conversion($configuration['target'], $configuration['currency']); ?>
                                </p>
                            </div>
                        </div>
                        
                        <div class="col-md-3 text-center">
                            <div class="">
                                <label class="control-label"><b>Head Count Tgt:</b></label>
                                <p id="ri-in-progress" class="form-control-static">
                                    <?php echo $configuration['headcount_tar']; ?>
                                </p>
                            </div>
                        </div>
                        
                        <div class="col-md-3 text-left">
                            <div class="">
                                <label class="control-label"><b>Region:</b></label>
                                <p id="ri-in-progress" class="form-control-static">
                                    <?php echo $configuration['region_filter']; ?>
                                </p>
                            </div>
                        </div>
                        
                        <div class="col-md-3 text-center">
                            <div class="">
                                <label class="control-label"><b>Service Type:</b></label>
                                <p id="ri-in-progress" class="form-control-static">
                                    <?php echo ucwords($configuration['service_type_filter']); ?>
                                </p>
                            </div>
                        </div>
                        
                        <div class="col-md-3 text-center">
                            <div class="">
                                <label class="control-label"><b>Customer Name:</b></label>
                                <p id="ri-in-progress" class="form-control-static">
                                    <?php echo $cust_name['cust_name'] ? ucwords($cust_name['cust_name']) : 'All'; ?>
                                </p>
                            </div>
                        </div>
                        
                        <div class="col-md-3 text-center">
                            <div class="">
                                <label class="control-label"><b>Service By:</b></label>
                                <p id="ri-in-progress" class="form-control-static">
                                    <?php echo $service_by['emp_name'] ? ucwords($service_by['emp_name']) : 'All'; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-3 text-left">
                            <div class="">
                                <label class="control-label"><b>Sales By:</b></label>
                                <p id="ri-in-progress" class="form-control-static">
                                    <?php echo $sales_by['emp_name'] ? ucwords($sales_by['emp_name']) : 'All'; ?>
                                </p>
                            </div>
                        </div>
                        
                        
                        <div class="col-md-4 text-center">
                            <div class="">
                                <p class="form-control-static legend-box">
                                    <span class="legend-color-box dvs"></span> DVS
                                </p>
                                <p class="form-control-static legend-box">
                                    <span class="legend-color-box dps"></span> DPS
                                </p>
                                <p class="form-control-static legend-box">
                                    <span class="legend-color-box custom"></span> Custom
                                </p>
                                <p class="form-control-static legend-box">
                                    <span class="legend-color-box others"></span> Others
                                </p>
                            </div>
                        </div>
                        
                        <div class="col-md-3 text-center">
                            <div class="">
                                <p class="form-control-static">
                                    <a class="btn btn-xs purple" href="#" data-toggle="modal" data-target="#myModal1" >
                                        <i class="fa fa-edit"></i> Edit
                                    </a>
                                </p>
                            </div>
                        </div>
                    
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-8">
            <!-- Section for showing YTD, MTD and Department WISE -->
            <div class="row">
                <!-- Section for showing YTD -->
                <div class="col-md-6">
                    <?php   
                        $month = date("m", strtotime('-3 month')); 
                        $ytd_target = $configuration['monthly_target']*$month;
                        $ytd_bar = ($ytd_target/$configuration['target'])*100;
                        
                        $shortfall = $revenue_ytd - $ytd_target;
                        $shortfall_per = ($shortfall/$ytd_target)*100;
                        $class = ($shortfall < 0) ? 'danger' : 'success'; 
                        
                        $growth = $revenue_ytd - $revenue_lytd;
                        $growth_class = ($growth < 0) ? 'danger' : 'success'; 
                    ?>
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption">
                                <span class="caption-subject bold uppercase"> YTD Revenue Details </span>
                            </div>
                            
                            <div class="portlet-indicator">
                                <?php if($shortfall < 0) { ?>
                                    <i class="fa fa-frown-o text-danger"></i>
                                <?php } else { ?>
                                    <i class="fa fa-smile-o text-success"></i>
                                <?php } ?>
                            </div>
                        </div>
                               
                        <div class="portlet-body">
                            <span class="text-<?php echo $class; ?>">
                                <?php echo round(($revenue_ytd/$configuration['target'])*100)?>% 
                                (<small><i class="fa <?php echo $symbol_class; ?>"></i></small> <?php echo conversion($revenue_ytd, $currency); ?>) 
                            </span>
                            <span class="pull-right text-primary">
                                <small><i class="fa <?php echo $symbol_class; ?>"></i></small>
                                <b><?php echo conversion($configuration['target'], $currency); ?></b>
                            </span>
                            
                            
                            <div class="progress">
                                <div class="progress-marker progress-<?php echo $class; ?>" style="left:<?php echo $ytd_bar ?>%;"></div>
                                
                                <div style="width: <?php echo round($revenue_ytd/$configuration['target']*100)?>%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="40" 
                                role="progressbar" class="progress-bar progress-bar-<?php echo $class; ?>">
                                </div>
                            </div>  
                            
                            <div class="row">
                                <div class="col-md-4 col-sm-4 col-xs-6">
                                    <div class="uppercase profile-stat-title">
                                        <small><i class="fa <?php echo $symbol_class; ?>"></i></small> 
                                        <?php echo conversion($revenue_lytd, $currency); ?>
                                    </div>
                                    <div class="uppercase profile-stat-text"> LYTD </div>
                                </div>
                                
                                
                                <div class="col-md-3 col-sm-4 col-xs-6">
                                    <div class="uppercase profile-stat-title text-<?php echo $growth_class; ?>">
                                        <?php echo $revenue_lytd ? round(($growth/$revenue_lytd)*100) : '0' ?> %
                                    </div>
                                    <div class="uppercase profile-stat-text"> Growth </div>
                                </div>
                                
                                <div class="col-md-5 col-sm-4 col-xs-6">
                                    <div class="uppercase profile-stat-title text-<?php echo $class; ?>">
                                        <?php echo round($shortfall_per) ?>%
                                        (<small><i class="fa <?php echo $symbol_class; ?>"></i></small> 
                                        <?php echo conversion($shortfall, $currency); ?>)
                                    </div>
                                    <div class="uppercase profile-stat-text"> Shortfall </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
                
                <!-- Section for showing MTD-->
                <div class="col-md-6">
                    <?php   
                        $mtd_comp = date("d")/date("t");
                        $mtd_target = round($configuration['monthly_target']*$mtd_comp);

                        $mtd_bar = ($mtd_target/$configuration['monthly_target'])*100;

                        $shortfall_mtd = $revenue_mtd - $mtd_target;
                        $shortfall_mtd_per = ($shortfall_mtd/$mtd_target)*100;
                        $class = ($shortfall_mtd < 0) ? 'danger' : 'success'; 
                        
                        $growth_mtd = $revenue_mtd - $revenue_lymtd;
                        $growth_class = ($growth_mtd < 0) ? 'danger' : 'success'; 
                    ?>
                    
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption">
                                <span class="caption-subject bold uppercase"> MTD Revenue Details </span>
                            </div>
                            
                            <div class="portlet-indicator">
                                <?php if($shortfall_mtd < 0) { ?>
                                    <i class="fa fa-frown-o text-danger"></i>
                                <?php } else { ?>
                                    <i class="fa fa-smile-o text-success"></i>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="portlet-body">
                            <span class="text-<?php echo $class; ?>">
                                <?php echo round(($revenue_mtd/$configuration['monthly_target'])*100)?>% 
                                (<small><i class="fa <?php echo $symbol_class; ?>"></i></small> <?php echo conversion($revenue_mtd, $currency); ?>) 
                            </span>
                            <span class="pull-right text-primary">
                                <small><i class="fa <?php echo $symbol_class; ?>"></i></small>
                                <b><?php echo conversion($configuration['monthly_target'], $currency); ?></b>
                            </span>
                            <div class="progress">
                                <div class="progress-marker progress-<?php echo $class; ?>" style="left:<?php echo $mtd_bar ?>%;"></div>
                                
                                <div style="width: <?php echo round($revenue_mtd/$mtd_target*100); ?>%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="40" role="progressbar" class="progress-bar progress-bar-<?php echo $class; ?>">
                                </div>
                            </div>  
                            
                            <div class="row">
                                <div class="col-md-4 col-sm-4 col-xs-6">
                                    <div class="uppercase profile-stat-title">
                                        <small><i class="fa <?php echo $symbol_class; ?>"></i></small> 
                                        <?php echo conversion($revenue_lymtd, $currency); ?> 
                                    </div>
                                    <div class="uppercase profile-stat-text"> LYMTD </div>
                                </div>
                                
                                <div class="col-md-3 col-sm-4 col-xs-6">
                                    <div class="uppercase profile-stat-title text-<?php echo $growth_class; ?>">
                                        <?php echo $revenue_lymtd ? round(($growth_mtd/$revenue_lymtd)*100) : '0' ?> %
                                    </div>
                                    <div class="uppercase profile-stat-text"> Growth </div>
                                </div>
                                
                                <div class="col-md-5 col-sm-4 col-xs-6">
                                    <div class="uppercase profile-stat-title text-<?php echo $class; ?>">
                                        <?php echo round($shortfall_mtd_per) ?>%
                                        (<small><i class="fa <?php echo $symbol_class; ?>"></i></small> 
                                        <?php echo conversion($shortfall_mtd, $currency); ?>)
                                    </div>
                                    <div class="uppercase profile-stat-text"> Shortfall </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                 
            </div>
            
            <div class="row">  
                <div class="col-md-12">
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption">
                                <span class="caption-subject bold uppercase"> Monthly Revenue </span>
                            </div>
                            <div class="actions">
                                <div class="">
                                    <p class="form-control-static legend-box">
                                        <span class="legend-color-box y2015"></span> 2015
                                    </p>
                                    <p class="form-control-static legend-box">
                                        <span class="legend-color-box y2016"></span> 2016
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div id="morris_chart_2" style="height:200px;"></div>  
                        </div>
                    </div>
                </div>
                
            </div>
                
            <div class="breadcrumbs">
                <h1>
                    Human Resource
                </h1>
            </div>
            
            <div class="row">
                <div class="col-md-12">
                    <!-- BEGIN Portlet PORTLET-->
                    <div class="portlet light bordered">

                        <div class="portlet-body">
                            <?php 
                                $perc_to_target = round(($head_count/$configuration['headcount_tar'])*100, 2);
                                $balance     = $configuration['headcount_tar'] - $head_count;
                            ?>
                            
                            <div class="row">
                                <div class="col-md-4 col-sm-4 col-xs-6">
                                    <div class="number text-center">
                                        <h3 class="text-primary">
                                            <span data-value="<?php echo $head_count; ?>" data-counter="counterup"><?php echo $head_count; ?></span>
                                        </h3>
                                        <small>Head Count</small>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-6">
                                    <div class="number text-center">
                                        <h3>
                                            <span data-value="<?php echo $perc_to_target; ?>" data-counter="counterup"><?php echo $perc_to_target; ?></span>
                                            <small>%</small>
                                        </h3>
                                        <small>% to target</small>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-6">
                                    <div class="number text-center">
                                        <h3>
                                            <span data-value="<?php echo $balance; ?>" data-counter="counterup"><?php echo $balance; ?></span>
                                        </h3>
                                        <small>Balance to hire</small>
                                    </div>
                                </div>
                                
                            </div>
                            
                            <div class="row">
                                <div style="margin-left:20px;margin-right:20px;">
                                    <div class="progress-info">
                                        <div class="progress">
                                            <span class="progress-bar progress-bar-danger" style="width: <?php echo $perc_to_target; ?>%;">
                                                <span class="sr-only"><?php echo $perc_to_target; ?>%</span>
                                            </span>
                                        </div>
                                        <!--
                                        <div class="status">
                                            <div class="status-title"> Progress </div>
                                            <div class="status-number"> 85% </div>
                                        </div>
                                        -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END Portlet PORTLET-->
                </div>
            
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="portlet light bordered">
                        
                        <div class="portlet-body">
                            <div class="row">
                                <div class="col-md-3">
                                    
                                </div>
                                <div class="col-md-3">
                                    <div class="number text-center">
                                        <small>Offered</small>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="number text-center">
                                        <small>Discarded</small>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="number text-center">
                                        <small>Resigned</small>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row" style="margin-top:10px;">
                                <div class="col-md-3 text-center">
                                    <span class="bold uppercase" style="font-size:16px;color:#666;"> YTD </span>
                                </div>
                                <div class="col-md-3">
                                    <div class="number text-center">
                                        <h3 class="text-primary">
                                            <span data-value="<?php echo $offered; ?>" data-counter="counterup"><?php echo $offered; ?></span>
                                        </h3>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="number text-center">
                                        <h3 class="text-primary">
                                            <span data-value="<?php echo $discarded; ?>" data-counter="counterup"><?php echo $discarded; ?></span>
                                        </h3>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="number text-center">
                                        <h3 class="text-primary">
                                            <span data-value="<?php echo $rejected; ?>" data-counter="counterup"><?php echo $rejected; ?></span>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row" style="margin-top:10px;">
                                <div class="col-md-3 text-center">
                                    <span class="bold uppercase" style="font-size:16px;color:#666;"> MTD </span>
                                </div>
                                <div class="col-md-3">
                                    <div class="number text-center">
                                        <h3 class="text-primary">
                                            <span data-value="<?php echo $offered_mtd; ?>" data-counter="counterup"><?php echo $offered_mtd; ?></span>
                                        </h3>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="number text-center">
                                        <h3 class="text-primary">
                                            <span data-value="<?php echo $discarded_mtd; ?>" data-counter="counterup"><?php echo $discarded_mtd; ?></span>
                                        </h3>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="number text-center">
                                        <h3 class="text-primary">
                                            <span data-value="<?php echo $rejected_mtd; ?>" data-counter="counterup"><?php echo $rejected_mtd; ?></span>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="portlet light bordered">
                        
                        <div class="portlet-body">
                            <div class="row">
                                <div class="col-md-4">
                                    
                                </div>
                                <div class="col-md-4">
                                    <div class="number text-center">
                                        <small>Joined</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="number text-center">
                                        <small>Resigned</small>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row" style="margin-top:10px;">
                                <div class="col-md-4 text-center">
                                    <span class="bold uppercase" style="font-size:16px;color:#666;"> YTD </span>
                                </div>
                                <div class="col-md-4">
                                    <div class="number text-center">
                                        <h3 class="text-primary">
                                            <span data-value="<?php echo $joined; ?>" data-counter="counterup"><?php echo $joined; ?></span>
                                        </h3>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="number text-center">
                                        <h3 class="text-primary">
                                            <span data-value="<?php echo $resigned; ?>" data-counter="counterup"><?php echo $resigned; ?></span>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row" style="margin-top:10px;">
                                <div class="col-md-4 text-center">
                                    <span class="bold uppercase" style="font-size:16px;color:#666;"> MTD </span>
                                </div>
                                <div class="col-md-4">
                                    <div class="number text-center">
                                        <h3 class="text-primary">
                                            <span data-value="<?php echo $joined_mtd; ?>" data-counter="counterup"><?php echo $joined_mtd; ?></span>
                                        </h3>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="number text-center">
                                        <h3 class="text-primary">
                                            <span data-value="<?php echo $resigned_mtd; ?>" data-counter="counterup"><?php echo $resigned_mtd; ?></span>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    
        <div class="col-md-4">
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light bordered dept-portlet">
                        
                        <div class="portlet-body">
                            <span class="bold uppercase" style="font-size:16px;color:#666;"> Department wise YTD </span>
                            <div class="progress">
                                <?php foreach($revenue_ytd_dept as $ryd) { ?>    
                                    <?php 
                                        $color = '#C8D046';
                                        if($ryd['sub_dept'] == 'DVS') {
                                            $color = '#005982';
                                        } else if($ryd['sub_dept'] == 'DPS') {
                                            $color = '#f26e22';
                                        } else if($ryd['sub_dept'] == 'Custom') {
                                            $color = '#1BBC9B';
                                        }
                                        
                                        $perc = round(($ryd['amt']/$revenue_ytd)*100);
                                    ?>
                                
                                    <div style="width: <?php echo $perc; ?>%;background-color:<?php echo $color; ?>" class="progress-bar">
                                        <span> <?php echo $perc; ?>% </span>     
                                    </div>
                                <?php } ?>
                            </div>
                            
                            <hr style="margin-bottom:8px;"/>
                            <span class="bold uppercase" style="font-size:16px;color:#666;"> Department wise MTD </span>
                            <div class="progress">
                                <?php foreach($revenue_mtd_dept as $rmd) { ?>    
                                    <?php 
                                        $color = '#C8D046';
                                        if($ryd['sub_dept'] == 'DVS') {
                                            $color = '#005982';
                                        } else if($ryd['sub_dept'] == 'DPS') {
                                            $color = '#f26e22';
                                        } else if($ryd['sub_dept'] == 'Custom') {
                                            $color = '#1BBC9B';
                                        }
                                        
                                        $perc = round(($rmd['amt']/$revenue_mtd)*100);
                                    ?>
                                
                                    <div style="height: <?php echo $perc; ?>%;background-color:<?php echo $color; ?>" class="progress-bar">
                                        <span class="sr-only"> <?php echo $perc; ?>% </span>
                                    </div>
                                <?php } ?>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light bordered dept-portlet">
                        
                        <div class="portlet-body">
                            <div class="market-stats bold uppercase">
                                <small class="text-primary"><i class="fa <?php echo $symbol_class; ?>"></i></small>
                                <span class=" market-stats-figure text-primary"> 
                                    <?php echo conversion($revenue_total['total'], $currency); ?> 
                                </span>
                                <small>Total Revenue</small>
                            </div>
                            
                            <div class="progress lg-progress">
                                <?php 
                                    $dvs = $revenue_total['total'] ? round(($revenue_total['dvs']/$revenue_total['total'])*100) : 0; 
                                    $dps = $revenue_total['total'] ? round(($revenue_total['dps']/$revenue_total['total'])*100) : 0; 
                                    $custom = $revenue_total['total'] ? round(($revenue_total['custom']/$revenue_total['total'])*100) : 0; 
                                ?>
                                <div style="width: <?php echo $dvs; ?>%;background-color:#005982;" class="progress-bar">
                                    <span> <?php echo $dvs; ?>% </span>     
                                </div>
                                <div style="width: <?php echo $dps; ?>%;background-color:#f26e22;" class="progress-bar">
                                    <span> <?php echo $dps; ?>% </span>     
                                </div>
                                <div style="width: <?php echo $custom; ?>%;background-color:#1BBC9B;" class="progress-bar">
                                    <span> <?php echo $custom; ?>% </span>     
                                </div>

                            </div>
                            
                            <hr />
                            
                            <div class="market-stats bold uppercase">
                                <small class="text-primary"><i class="fa <?php echo $symbol_class; ?>"></i></small>
                                <span class=" market-stats-figure text-primary"> 
                                    <?php echo conversion($collected['total'], $currency); ?> 
                                    <small>(<?php echo $revenue_total['total'] ? round(($collected['total']/$revenue_total['total'])*100) : 0; ?>%)</small>
                                </span>
                                <small>Collected</small>
                            </div>
                            
                            <div class="progress lg-progress">
                                <?php 
                                    $dvs = $collected['total'] ? round(($collected['dvs']/$collected['total'])*100) : 0; 
                                    $dps = $collected['total'] ? round(($collected['dps']/$collected['total'])*100) : 0; 
                                    $custom = $collected['total'] ? round(($collected['custom']/$collected['total'])*100) : 0; 
                                ?>
                                <div style="width: <?php echo $dvs; ?>%;background-color:#005982;" class="progress-bar">
                                    <span> <?php echo $dvs; ?>% </span>     
                                </div>
                                <div style="width: <?php echo $dps; ?>%;background-color:#f26e22;" class="progress-bar">
                                    <span> <?php echo $dps; ?>% </span>     
                                </div>
                                <div style="width: <?php echo $custom; ?>%;background-color:#1BBC9B;" class="progress-bar">
                                    <span> <?php echo $custom; ?>% </span>     
                                </div>

                            </div>
                            
                            <hr />
                            
                            <div class="market-stats bold uppercase">
                                <small class="text-primary"><i class="fa <?php echo $symbol_class; ?>"></i></small>
                                <span class=" market-stats-figure text-primary"> 
                                    <?php echo conversion($receivable['total'], $currency); ?> 
                                    <small>(<?php echo $revenue_total['total'] ? round(($receivable['total']/$revenue_total['total'])*100) : 0; ?>%)</small>
                                </span>
                                <small>Receivable</small>
                            </div>
                            
                            <div class="progress lg-progress">
                                <?php 
                                    $dvs = $receivable['total'] ? round(($receivable['dvs']/$receivable['total'])*100) : 0; 
                                    $dps = $receivable['total'] ? round(($receivable['dps']/$receivable['total'])*100) : 0; 
                                    $custom = $receivable['total'] ? round(($receivable['custom']/$receivable['total'])*100) : 0; 
                                ?>
                                <div style="width: <?php echo $dvs; ?>%;background-color:#005982;" class="progress-bar">
                                    <span> <?php echo $dvs; ?>% </span>     
                                </div>
                                <div style="width: <?php echo $dps; ?>%;background-color:#f26e22;" class="progress-bar">
                                    <span> <?php echo $dps; ?>% </span>     
                                </div>
                                <div style="width: <?php echo $custom; ?>%;background-color:#1BBC9B;" class="progress-bar">
                                    <span> <?php echo $custom; ?>% </span>     
                                </div>

                            </div>
                        </div>
                    </div>
                        
                </div>
            </div>
        
            <!--
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light bordered dept-portlet">
                        <div class="portlet-title">
                            <div class="caption">
                                <span class="caption-subject bold uppercase"> AR Ageing </span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="number text-center">
                                        <h3 class="text-primary">
                                            <span data-value="9,35,429" data-counter="counterup">
                                                <small><i class="fa <?php echo $symbol_class; ?>"></i>
                                                </small><?php echo conversion($bucket['bucket1'], $currency); ?>
                                            </span>
                                            
                                            <small>(<?php echo $receivable['total'] ? round(($bucket['bucket1']/$receivable['total'])*100) : 0; ?>%)</small>
                                        </h3>
                                        <small>0-30 days</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="number text-center">
                                        <h3>
                                            <span data-value="9,35,429" data-counter="counterup">
                                                <small><i class="fa <?php echo $symbol_class; ?>"></i>
                                                </small><?php echo conversion($bucket['bucket2'], $currency); ?>
                                            </span>
                                            
                                            <small>(<?php echo $receivable['total'] ? round(($bucket['bucket2']/$receivable['total'])*100) : 0; ?>%)</small>
                                        </h3>
                                        <small>31-60 days</small>
                                    </div>
                                </div>
                            </div>
                            
                            <hr />
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="number text-center">
                                        <h3>
                                            <span data-value="9,35,429" data-counter="counterup">
                                                <small><i class="fa <?php echo $symbol_class; ?>"></i>
                                                </small><?php echo conversion($bucket['bucket3'], $currency); ?>
                                            </span>
                                            
                                            <small>(<?php echo $receivable['total'] ? round(($bucket['bucket3']/$receivable['total'])*100) : 0; ?>%)</small>
                                        </h3>
                                        <small>61-90 days</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="number text-center">
                                        <h3>
                                            <span data-value="9,35,429" data-counter="counterup">
                                                <small><i class="fa <?php echo $symbol_class; ?>"></i>
                                                </small><?php echo conversion($bucket['bucket4'], $currency); ?>
                                            </span>
                                            
                                            <small>(<?php echo $receivable['total'] ? round(($bucket['bucket4']/$receivable['total'])*100) : 0; ?>%)</small>
                                        </h3>
                                        <small>90+ days</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            -->
            
            <div class="row">  
                <div class="col-md-12">
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption">
                                <span class="caption-subject bold uppercase"> AR Agening </span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div id="ar_ageing_chart" style="height:180px;"></div>  
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    
    <div class="breadcrumbs">
        <h1>
            Customers
        </h1>
        <div class = "pull-right">
            <form class = "form-inline" method ="post">
                <div class="form-group">
                    <label class ="control-label">Show</label>
                <input type="text" class="required form-control" name= "customer_count">
                <input class="btn" type="submit" value="Submit">
                </div>
            </form>
    </div>
    </div>
    
    
    <div class="row">
        <div class="col-md-6">
            <!-- BEGIN Portlet PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <span class="caption-subject bold uppercase"> Top Customers </span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div id="chart1_div"></div> 
                    
                </div>
            </div>
            <!-- END Portlet PORTLET-->
        </div>
        
        <div class="col-md-6">
            <!-- BEGIN Portlet PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <span class="caption-subject bold uppercase"> Bottom Customers </span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div id="chart2_div"></div> 
                    
                </div>
            </div>
            <!-- END Portlet PORTLET-->
        </div>
    </div>
    
    
    
    <script src="<?php echo base_url(); ?>assets/new/global/plugins/morris/morris.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/new/global/plugins/morris/raphael-min.js" type="text/javascript"></script>
    <script>
        jQuery(document).ready(function() {
            var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            
            /*
            var dept_wise_revenue = [
                <?php foreach($dept_wise_rev as $key => $dept_rev){ ?>
                    { 
                        y: '<?php echo $dept_rev['invoice_month']; ?>', 
                        d1: <?php echo str_replace(',', '', conversion($dept_rev['dvs'], $currency)); ?>, 
                        d2: <?php echo str_replace(',', '', conversion($dept_rev['dps'], $currency)); ?>, 
                        d3: <?php echo str_replace(',', '', conversion($dept_rev['custom'], $currency)); ?>
                    },
                <?php } ?>
                
                <?php if(count($dept_wise_rev) < 3) { ?>
                    { y: '2016-06', d1: 0, d2: 0, d3: 0 },
                <?php } ?>
                
                <?php if(count($dept_wise_rev) < 4) { ?>
                    { y: '2016-07', d1: 0, d2: 0, d3: 0 },
                <?php } ?>
            ]
            new Morris.Area({
                element: 'morris_chart_2',
                data: dept_wise_revenue,
                xkey: 'y',
                ykeys: ['d1', 'd2', 'd3'],
                labels: ['DVS', 'DPS', 'Custom'],
                lineColors: ['#005982', '#f26e22', '#1BBC9B'],
                hideHover: true,
                xLabelFormat: function (x) { return months[x.getMonth()]; }
            });
            */
            var year_wise_monthly_rev = [
                <?php foreach($year_wise_monthly_rev as $key => $year_rev){ ?>
                    { 
                        y: '<?php echo $year_rev['invoice_month']; ?>', 
                        y1: <?php echo str_replace(',', '', conversion($year_rev['y2015'], $currency)); ?>, 
                        y2: <?php echo str_replace(',', '', conversion($year_rev['y2016'], $currency)); ?>
                    },
                <?php } ?>
            ]
            new Morris.Area({
                element: 'morris_chart_2',
                data: year_wise_monthly_rev,
                xkey: 'y',
                ykeys: ['y1', 'y2'],
                labels: ['2015', '2016'],
                lineColors: ['#B0B0B0', '#0D4F8B'],
                hideHover: true,
                xLabelFormat: function (x) { return months[x.getMonth()]; }
            });
            
            new Morris.Bar({
                element: 'ar_ageing_chart',
                data: [
                    { y: '0~30 days', a: <?php echo str_replace(',', '', conversion($bucket['bucket1'], $currency)); ?> },
                    { y: '31-60 days', a: <?php echo str_replace(',', '', conversion($bucket['bucket2'], $currency)); ?> },
                    { y: '61-90 days', a: <?php echo str_replace(',', '', conversion($bucket['bucket3'], $currency)); ?> },
                    { y: '91+ days', a: <?php echo str_replace(',', '', conversion($bucket['bucket4'], $currency)); ?> }
                ],
                xkey: 'y',
                ykeys: ['a'],
                labels: ['<?php echo $currency; ?>'],
                hoverCallback: function (index, options, content, row) {
                    return content+'<div class="text-center"><a href="#" data-toggle="modal" data-target="#BucketModal'+index+'">Show Details</a></div>';
                }
            });
            
            $('.currency-radio').change(function() {
                $currency = $('.currency-radio:checked').val();
                
                window.location.href = '<?php echo base_url(); ?>'+'dashboard/currency/'+$currency;
                
            });
        });
        
    </script>
    
</div>

<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Configuration</h4>
            </div>
            
            <form action=" <?php echo base_url().'dashboard/configuration'?>" method="post">
                <div class="modal-body">
                
                    <div class="form-body">
                        <div class="alert alert-danger display-hide">
                            <button class="close" data-close="alert"></button>
                            You have some form errors. Please check below.
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Currency:</label>
                                    <select  name="currency" class="form-control select2me"
                                        data-placeholder="Select Currency ">
                                       
                                        <option value=""></option>
                                        <option value="Rupee" <?php if(isset($configuration['currency']) && $configuration['currency'] == 'Rupee') { ?>selected="selected"<?php } ?>>Rupee</option>
                                        <option value="Dollar" <?php if(isset($configuration['currency']) && $configuration['currency'] == 'Dollar') { ?>selected="selected"<?php } ?>>Dollar</option>
                                    </select>
                                    
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Conversion:</label>
                                    <input type="text" class="required form-control" name="conversion"
                                    value="<?php echo isset($configuration['conversion']) ? $configuration['conversion'] : ''; ?>">		
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="name">Target(<small><i class="fa fa-rupee"></i></small></label>):
                                    <input type="text" class="required form-control" name="target"
                                    value="<?php echo isset($configuration['target']) ? $configuration['target'] : ''; ?>">
                                    <span class="help-block">
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Head Count Target:</label>
                                    <input type="text" class="required form-control" name="headcount_tar"
                                    value="<?php echo isset($configuration['headcount_tar']) ? $configuration['headcount_tar'] : ''; ?>">
                                    <span class="help-block">
                                    </span>	
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Region Filter:</label>
                                    <select  name="region_filter" class="form-control select2me"
                                        data-placeholder="Select Region ">
                                        <option value=""></option>
                                        <option value="All" <?php if(isset($configuration['region_filter']) && $configuration['region_filter'] == 'All') { ?>selected="selected"<?php } ?>>All</option>
                                        <option value="North" <?php if(isset($configuration['region_filter']) && $configuration['region_filter'] == 'North') { ?>selected="selected"<?php } ?>>North</option>
                                        <option value="South" <?php if(isset($configuration['region_filter']) && $configuration['region_filter'] == 'South') { ?>selected="selected"<?php } ?>>South</option>      
                                        <option value="East" <?php if(isset($configuration['region_filter']) && $configuration['region_filter'] == 'East') { ?>selected="selected"<?php } ?>>East</option>      
                                        <option value="West" <?php if(isset($configuration['region_filter']) && $configuration['region_filter'] == 'West') { ?>selected="selected"<?php } ?>>West</option>      
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Service Type Filter:</label>
                                    <select name="service_type_filter" class="form-control select2me"
                                        data-placeholder="Select Service Type ">
                                       
                                        <option value="both" <?php if(isset($configuration['service_type_filter']) && $configuration['service_type_filter'] == 'both') { ?>selected="selected"<?php } ?>>Both</option>
                                        <option value="service" <?php if(isset($configuration['service_type_filter']) && $configuration['service_type_filter'] == 'service') { ?>selected="selected"<?php } ?>>Service</option>
                                        <option value="product" <?php if(isset($configuration['service_type_filter']) && $configuration['service_type_filter'] == 'product') { ?>selected="selected"<?php } ?>>Product</option>
                                    </select>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="name">Customer Name: </label>
                                    <select name="customer_name[]" multiple class="form-control select2me"
                                        data-placeholder="All">
                                        
                                        <?php 
                                            $sel_customer = isset($configuration['customer_name']) ? $configuration['customer_name'] : ''; 
                                            $sel_customer = explode(',', $sel_customer);
                                        ?>
                                        <?php foreach ($customer_alls as $customer_all){ ?>
                                            <option value="<?php echo $customer_all['id']?>" <?php if(in_array($customer_all['id'], $sel_customer)) { ?>selected="selected"<?php } ?>>   
                                                <?php echo $customer_all['name']?>
                                            </option>
                                       <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Service By:</label>
                                    <select name="service_given[]" multiple class="form-control select2me"
                                        data-placeholder="All">
                                        
                                        <?php
                                            $sel_service = isset($configuration['service_by']) ? $configuration['service_by'] : '';
                                            $sel_service = explode(',', $sel_service);
                                        ?>
                                        <?php foreach ($services_alls as $services_all) { ?>
                                            <option value="<?php echo $services_all['service_by']?>"<?php if(in_array($services_all['service_by'],$sel_service)){ ?>selected="selected"<?php } ?>>
                                                <?php echo $services_all['service_given']?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="name">Sales By:</label>
                                    <select name="sales_given[]" multiple class="form-control select2me"
                                        data-placeholder="All">
                                        
                                        <?php 
                                            $sel_sales = isset($configuration['sales_by']) ? $configuration['sales_by'] : '';
                                            $sel_sales = explode(',', $sel_sales) ;
                                        ?>        
                                        <?php foreach ($sales_alls as $sales_all) { ?>
                                            <option value="<?php echo $sales_all['sales_person']?>"<?php if(in_array($sales_all['sales_person'],$sel_sales)) { ?>selected="selected" <?php } ?>>
                                                <?php echo $sales_all['sales_given']?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>    
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn green" type="submit">Submit</button>
                    <button data-dismiss="modal" class="btn dark btn-outline" type="button">Close</button>
                </div>
            </form>
        </div>    
    </div>
</div> 
<div class="modal bs-modal-lg fade" id="BucketModal0" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Configuration</h4>
            </div>
            
             <form role="form" action="<?php echo base_url()."report/send_reminder"?>"  class="validate-form" method="post">
                <div class="modal-body">
                    <div class="form-body">
                        <div class="alert alert-danger display-hide">
                            <button class="close" data-close="alert"></button>
                            You have some form errors. Please check below.
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table non-dt-checkable-table-modal table-hover table-responsive table-custom " >
                                    <thead>
                                        <tr>
                                            <th>
                                                <input type="checkbox" class="group-checkable insight-check-all" data-set=".non-dt-checkable-table-modal .checkboxes" /> 
                                            </th>
                                            <th>Customer Name</th>
                                            <th>Invoice No.</th>
                                            <th>Invoice Date</th>
                                            <th>Invoice Amt</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                     <?php foreach($ageing_buc as $ageing_bucs) { ?>
                                        <tr>
                                            <td>
                                                <input  type="checkbox" name="invoice_ids[]" class="checkboxes insight-check" 
                                                    value="<?php echo $ageing_buckes['invoice_id']; ?>" /> 
                                            </td>
                                            <td><?php echo $ageing_bucs['name']?></td>
                                            <td><?php echo $ageing_bucs['invoice_no']?></td>
                                            <td><?php echo $ageing_bucs['invoice_date']?></td>
                                            <td><?php echo $ageing_bucs['invoice_amt']?></td>
                                        </tr>  
                                    <?php } ?>
                                    </tbody> 
                                </table> 
                            </div>
                            <div class="col-md-4">
                                <div id="reminder" style="display:none">
                                    <input type="hidden" name="invoice_ids[]" />
                                    <div>
                                        <label class="control-label" for="from">Reminder:</label>
                                        <label class='radio-inline'>
                                            <input type="radio" name="reminder" value="0" data-title="0">
                                            Reminder 
                                        </label>
                                        <label class='radio-inline'>
                                            <input type="radio" name="reminder" value="1" data-title="1">
                                            One 
                                        </label>
                                        <label class='radio-inline'>
                                            <input type="radio" name="reminder" value="2" data-title="2">
                                           Two
                                        </label>
                                        <label class='radio-inline'>
                                            <input type="radio" name="reminder" value="3" data-title="3">
                                            Three
                                        </label>
                                        <label class='radio-inline'>
                                            <input type="radio" name="reminder" value="4" data-title="4">
                                           Four
                                        </label>
                                        <label class='radio-inline'>
                                            <input type="radio" name="reminder" value="5" data-title="5">
                                            Five
                                        </label>
                                    </div>
                                    <div class="form-group" style="margin-top:10px;">
                                        <label class="control-label">To :</label>
                                        <input type="text" name="emails" class="form-control"></input> 
                                    </div>
                                    <div class="form-group" style="margin-top:10px;">
                                        <label class="control-label">CC :</label>
                                        <input type="text" name="cc" class="form-control" value="<?php echo isset($cc) ? $cc : '';?>"></input>
                                    </div>
                                    <div style="margin-top:10px;">
                                        <button class="btn green" type="submit"  >Send</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn green" type="button">Close</button>
                </div>
            </form>
        </div>    
    </div>
</div>
<div class="modal bs-modal-lg fade" id="BucketModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Configuration</h4>
            </div>
            <form role="form" action="<?php echo base_url()."report/send_reminder"?>"  class="validate-form" method="post">
                <div class="modal-body">
                    <div class="form-body">
                        <div class="alert alert-danger display-hide">
                            <button class="close" data-close="alert"></button>
                            You have some form errors. Please check below.
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table non-dt-checkable-table-modal table-hover table-responsive table-custom " >
                                    <thead>
                                        <tr>
                                            <th>
                                                <input type="checkbox" class="group-checkable insight-check-all" data-set=".non-dt-checkable-table-modal .checkboxes" /> 
                                            </th>
                                            <th>Customer Name</th>
                                            <th>Invoice No.</th>
                                            <th>Invoice Date</th>
                                            <th>Invoice Amt</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                     <?php foreach($ageing_buck as $ageing_bucks) { ?>
                                        <tr>
                                            <td>
                                                <input  type="checkbox" name="invoice_ids[]" class="checkboxes insight-check" 
                                                    value="<?php echo $ageing_bucks['invoice_id']; ?>" /> 
                                            </td>
                                            <td><?php echo $ageing_bucks['name']?></td>
                                            <td><?php echo $ageing_bucks['invoice_no']?></td>
                                            <td><?php echo $ageing_bucks['invoice_date']?></td>
                                            <td><?php echo $ageing_bucks['invoice_amt']?></td>
                                        </tr>  
                                    <?php } ?>
                                    </tbody> 
                                </table> 
                            </div>
                            <div class="col-md-4">
                                <div id="reminder" style="display:none">
                                    <input type="hidden" name="invoice_ids[]" />
                                    <div>
                                        <label class="control-label" for="from">Reminder:</label>
                                        <label class='radio-inline'>
                                            <input type="radio" name="reminder" value="0" data-title="0">
                                            Reminder 
                                        </label>
                                        <label class='radio-inline'>
                                            <input type="radio" name="reminder" value="1" data-title="1">
                                            One 
                                        </label>
                                        <label class='radio-inline'>
                                            <input type="radio" name="reminder" value="2" data-title="2">
                                           Two
                                        </label>
                                        <label class='radio-inline'>
                                            <input type="radio" name="reminder" value="3" data-title="3">
                                            Three
                                        </label>
                                        <label class='radio-inline'>
                                            <input type="radio" name="reminder" value="4" data-title="4">
                                           Four
                                        </label>
                                        <label class='radio-inline'>
                                            <input type="radio" name="reminder" value="5" data-title="5">
                                            Five
                                        </label>
                                    </div>
                                    <div class="form-group" style="margin-top:10px;">
                                        <label class="control-label">To :</label>
                                        <input type="text" name="emails" class="form-control"></input> 
                                    </div>
                                    <div class="form-group" style="margin-top:10px;">
                                        <label class="control-label">CC :</label>
                                        <input type="text" name="cc" class="form-control" value="<?php echo isset($cc) ? $cc : '';?>"></input>
                                    </div>
                                    <div style="margin-top:10px;">
                                        <button class="btn green" type="submit"  >Send</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn green" type="button">Close</button>
                </div>
            </form>
        </div>    
    </div>
</div>                          
<div class="modal bs-modal-lg fade" id="BucketModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Configuration</h4>
            </div>
            <form role="form" action="<?php echo base_url()."report/send_reminder"?>"  class="validate-form" method="post">
                <div class="modal-body">
                    <div class="form-body">
                        <div class="alert alert-danger display-hide">
                            <button class="close" data-close="alert"></button>
                            You have some form errors. Please check below.
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table non-dt-checkable-table-modal table-hover table-responsive table-custom " >
                                    <thead>
                                        <tr>
                                            <th>
                                                <input type="checkbox" class="group-checkable insight-check-all" data-set=".non-dt-checkable-table-modal .checkboxes" /> 
                                            </th>
                                            <th>Customer Name</th>
                                            <th>Invoice No.</th>
                                            <th>Invoice Date</th>
                                            <th>Invoice Amt</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                     <?php foreach($ageing_bucke as $ageing_buckes) { ?>
                                        <tr>
                                            <td>
                                                <input  type="checkbox" name="invoice_ids[]" class="checkboxes insight-check" 
                                                    value="<?php echo $ageing_buckes['invoice_id']; ?>" /> 
                                            </td>
                                            <td><?php echo $ageing_buckes['name']?></td>
                                            <td><?php echo $ageing_buckes['invoice_no']?></td>
                                            <td><?php echo $ageing_buckes['invoice_date']?></td>
                                            <td><?php echo $ageing_buckes['invoice_amt']?></td>
                                        </tr>  
                                    <?php } ?>
                                    </tbody> 
                                </table> 
                            </div>
                            <div class="col-md-4">
                                <div id="reminder" style="display:none">
                                    <input type="hidden" name="invoice_ids[]" />
                                    <div>
                                        <label class="control-label" for="from">Reminder:</label>
                                        <label class='radio-inline'>
                                            <input type="radio" name="reminder" value="0" data-title="0">
                                            Reminder 
                                        </label>
                                        <label class='radio-inline'>
                                            <input type="radio" name="reminder" value="1" data-title="1">
                                            One 
                                        </label>
                                        <label class='radio-inline'>
                                            <input type="radio" name="reminder" value="2" data-title="2">
                                           Two
                                        </label>
                                        <label class='radio-inline'>
                                            <input type="radio" name="reminder" value="3" data-title="3">
                                            Three
                                        </label>
                                        <label class='radio-inline'>
                                            <input type="radio" name="reminder" value="4" data-title="4">
                                           Four
                                        </label>
                                        <label class='radio-inline'>
                                            <input type="radio" name="reminder" value="5" data-title="5">
                                            Five
                                        </label>
                                    </div>
                                    <div class="form-group" style="margin-top:10px;">
                                        <label class="control-label">To :</label>
                                        <input type="text" name="emails" class="form-control"></input> 
                                    </div>
                                    <div class="form-group" style="margin-top:10px;">
                                        <label class="control-label">CC :</label>
                                        <input type="text" name="cc" class="form-control" value="<?php echo isset($cc) ? $cc : '';?>"></input>
                                    </div>
                                    <div style="margin-top:10px;">
                                        <button class="btn green" type="submit"  >Send</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn green" type="button">Close</button>
                </div>
            </form>
        </div>    
    </div>
</div>                          
<div class="modal bs-modal-lg fade" id="BucketModal3" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Configuration</h4>
            </div>
            <form role="form" action="<?php echo base_url()."report/send_reminder"?>"  class="validate-form" method="post">
                <div class="modal-body">
                    <div class="form-body">
                        <div class="alert alert-danger display-hide">
                            <button class="close" data-close="alert"></button>
                            You have some form errors. Please check below.
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table non-dt-checkable-table-modal table-hover table-responsive table-custom " >
                                    <thead>
                                        <tr>
                                            <th>
                                                <input type="checkbox" class="group-checkable insight-check-all" data-set=".non-dt-checkable-table-modal .checkboxes" /> 
                                            </th>
                                            <th>Customer Name</th>
                                            <th>Invoice No.</th>
                                            <th>Invoice Date</th>
                                            <th>Invoice Amt</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                     <?php foreach($ageing_bucket as $ageing_buckets) { ?>
                                        <tr>
                                            <td>
                                                <input  type="checkbox" name="invoice_ids[]" class="checkboxes insight-check" 
                                                    value="<?php echo $ageing_buckets['invoice_id']; ?>" /> 
                                            </td>
                                            <td><?php echo $ageing_buckets['name']?></td>
                                            <td><?php echo $ageing_buckets['invoice_no']?></td>
                                            <td><?php echo $ageing_buckets['invoice_date']?></td>
                                            <td><?php echo $ageing_buckets['invoice_amt']?></td>
                                        </tr>  
                                    <?php } ?>
                                    </tbody> 
                                </table> 
                            </div>
                            <div class="col-md-4">
                                <div id="reminder" style="display:none">
                                    <input type="hidden" name="invoice_ids[]" />
                                    <div>
                                        <label class="control-label" for="from">Reminder:</label>
                                        <label class='radio-inline'>
                                            <input type="radio" name="reminder" value="0" data-title="0">
                                            Reminder 
                                        </label>
                                        <label class='radio-inline'>
                                            <input type="radio" name="reminder" value="1" data-title="1">
                                            One 
                                        </label>
                                        <label class='radio-inline'>
                                            <input type="radio" name="reminder" value="2" data-title="2">
                                           Two
                                        </label>
                                        <label class='radio-inline'>
                                            <input type="radio" name="reminder" value="3" data-title="3">
                                            Three
                                        </label>
                                        <label class='radio-inline'>
                                            <input type="radio" name="reminder" value="4" data-title="4">
                                           Four
                                        </label>
                                        <label class='radio-inline'>
                                            <input type="radio" name="reminder" value="5" data-title="5">
                                            Five
                                        </label>
                                    </div>
                                    <div class="form-group" style="margin-top:10px;">
                                        <label class="control-label">To :</label>
                                        <input type="text" name="emails" class="form-control"></input> 
                                    </div>
                                    <div class="form-group" style="margin-top:10px;">
                                        <label class="control-label">CC :</label>
                                        <input type="text" name="cc" class="form-control" value="<?php echo isset($cc) ? $cc : '';?>"></input>
                                    </div>
                                    <div style="margin-top:10px;">
                                        <button class="btn green" type="submit"  >Send</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn green" type="button">Close</button>
                </div>
            </form>
        </div>    
    </div>
</div>                             
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script>
    google.charts.load('current', {packages: ['corechart', 'bar']});
    google.charts.setOnLoadCallback(topcustomer);

function topcustomer() {

      var data = google.visualization.arrayToDataTable([
        ['Customer', 'Revenue'],
        <?php foreach($top_customers as $top_customer) { ?>
        ['<?php echo $top_customer['name']; ?>', <?php echo str_replace(',', '', conversion($top_customer['amt'], $currency)); ?>], 
        <?php } ?>
        
      ]);

      var options = {
        chartArea: {width: '60%'}
      };

      var chart = new google.visualization.BarChart(document.getElementById('chart1_div'));

      chart.draw(data, options);
    }
    
google.charts.setOnLoadCallback(bottomcustomer);    
function bottomcustomer() {

      var data = google.visualization.arrayToDataTable([
        ['Customer', 'Revenue'],
        <?php foreach($bottom_customers as $bottom_customer) { ?>
        ['<?php echo $bottom_customer['name']; ?>', <?php echo str_replace(',', '', conversion($bottom_customer['amt'], $currency)); ?>], 
        <?php } ?>
        
      ]);

      var options = {
        chartArea: {width: '60%'}
      };

      var chart = new google.visualization.BarChart(document.getElementById('chart2_div'));

      chart.draw(data, options);
    }    
</script>



                       