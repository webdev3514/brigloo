<div class="page-content-wrap" style="margin-top:20px;">
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-success alert-dismissable pickup-success hide-el" style="display: none;">

                <a href="#" class="close close-msg" data-dismiss="alert" aria-label="close"><i class="fa fa-close"></i></a>

                <span class="pickup-msg"></span>

            </div>

            <div class="alert alert-danger alert-dismissable pickup-failed hide-el" style="display: none;">

                <a href="#" class="close close-msg" data-dismiss="alert" aria-label="close"><i class="fa fa-close"></i></a>

                <span class="pickup-msg"></span>

            </div>
            <form class="form-horizontal" style="display: none;" method="post" name="frm_edit_pickup" id="frm_edit_pickup" novalidate>
                <div class="panel panel-default">
                    <div class="pick-body">
                        <div class="panel-body  col-md-12 pickup-section">
                            <div class="panel-heading">
                                <h3 class="panel-title" style="text-transform: capitalize">Edit Recurring</h3>
                            </div>
                            <div style="margin-top: 60px;">
                                <div class="form-group pickup_location">
                                    <label class="col-md-3">Pick Up Location<span class="required-feild">*</span></label>
                                    <div class="col-md-3">
                                        <?php $location_data = $location->get_all_location( $user_id );  ?>
                                        <select class=" select" id="pickup_location" name="location">
<!--                                                <option value="0">Choose location</option>-->
                                            <?php 
                                            if( isset( $location_data ) ){
                                                foreach( $location_data as $l_data ){
                                            ?>
                                                    <option  value="<?php echo $l_data['in_location_id']; ?>"><?php echo $l_data['st_store_id']; ?></option>
                                            <?php } 
                                            }?>
                                        </select>                           
                                        <span class="">Don't see a location? <a href="" id='open_location_modal' data-toggle="modal" data-target="#add_pickup_location">Click Here</a> to add a new location.</span>
                                    </div>                        
                                </div>  
                                <input type="hidden" id="hdn_recurring_id" name="hdn_recurring_id" />
                                <div class="form-group recurring_collection">
                                    <label class="col-md-3">Recurring Type<span class="required-feild">*</span></label>
                                    <div class="col-md-3">                                   
                                        <label><input type="radio" class="recurring_type weekly_recurring_chk"  value="weekly" name="recurring_type"/>Weekly</label>
                                        <label><input type="radio" class="recurring_type monthly_recurring_chk"  value="monthly" name="recurring_type"/> Monthly</label>
                                    </div>                        
                                </div>

                                <div class="form-group weekly_recurring">
                                    <label class="col-md-3">Choose Day<span class="required-feild">*</span></label>
                                    <div class="col-md-3">
                                        <select class=" select" id="ch_delivery_time" name="pickup_weekly_recurring_date">
                                            <option  value="1">Monday</option>
                                            <option  value="2">Tuesday</option>
                                            <option  value="3">Wednesday</option>
                                            <option  value="4">Thursday</option>
                                            <option  value="5">Friday</option>
                                            <option  value="6">Saturday</option>
                                            <option  value="7">Sunday</option>
                                        </select>                          
                                    </div>                        
                                </div>
                                <div class="form-group monthly_recurring">                                        
                                    <label class="col-md-3">Monthly Date<span class="required-feild">*</span></label>
                                    <div class="col-md-3 calender_open">
                                        <div class="input-group">
                                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                            <input type="text" required="" class="form-control datepicker" id="pickup_monthly_recurring_date" name="pickup_monthly_recurring_date"/>             
                                        </div>
                                        <span class="help-block"></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3">Pick Up Amount ($)</label>
                                    <div class="col-md-3">
                                        <input type="number" class="pickup_amt form-control" id="pickup_amt" name="amt"/>
                                        <span class="help-block"></span>
                                        <span class="pickup_amount"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel-footer">  
                        <button type="submit" class="btn btn-primary pull-right loader">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>                    

</div>