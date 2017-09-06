<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            Travel Policy
        </h1>

    </div>
    <div class="row">
        <div class="col-md-12">

            <div class="portlet light bordered">

                <form class="form-horizontal" role="form">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table id="ticket_table" class="table table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Grade</th>
                                            <th>Mode of Travel</th>
                                            <th>Travel class</th>
                                            <th>Transport</th>
                                            <th colspan="3">City Class(A)</th>                                                
                                            <th colspan="3">City Class(B)</th>                                                
                                            <th colspan="3">City Class(C)</th>                                                
                                        </tr>
                                        <tr>
                                            <th colspan="4"></th>
                                            <th>Hotel</th>
                                            <th>DA</th>
                                            <th>Con</th>
                                            <th>Hotel</th>
                                            <th>DA</th>
                                            <th>Con</th>
                                            <th>Hotel</th>
                                            <th>DA</th>
                                            <th>Con</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($emp_policy as $key => $value) { ?>
                                            <tr>
                                                <td><?PHP echo $value['grade_name'] ?></td>
                                                <td><?PHP echo $value['name'] ?></td>
                                                <td><?PHP echo $value['travel_class'] ?></td>
                                                <td><?PHP echo $value['transport'] ?></td>
                                                <td><?PHP if (isset($value['hotel']['A'])) echo $value['hotel']['A']; ?></td>
                                                <td><?PHP if (isset($value['DA']['A'])) echo $value['DA']['A'] ?></td>
                                                <td><?PHP if (isset($value['DC']['A'])) echo $value['DC']['A'] ?></td>
                                                <td><?PHP if (isset($value['hotel']['B'])) echo $value['hotel']['B'] ?></td>
                                                <td><?PHP if (isset($value['DA']['B'])) echo $value['DA']['B'] ?></td>
                                                <td><?PHP if (isset($value['DC']['B'])) echo $value['DC']['B'] ?></td>
                                                <td><?PHP if (isset($value['hotel']['C'])) echo $value['hotel']['C'] ?></td>
                                                <td><?PHP if (isset($value['DA']['C'])) echo $value['DA']['C'] ?></td>
                                                <td><?PHP if (isset($value['DC']['C'])) echo $value['DC']['C'] ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
    <!--END PAGE CONTENT-->
</div>