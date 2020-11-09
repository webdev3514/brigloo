<div class="alert alert-success alert-dismissable pickup-success hide-el" style="display: none;">

    <a href="#" class="close close-msg" data-dismiss="alert" aria-label="close"><i class="fa fa-close"></i></a>

    <span class="pickup-msg"></span>

</div>

<div class="alert alert-danger alert-dismissable pickup-failed hide-el" style="display: none;">

    <a href="#" class="close close-msg" data-dismiss="alert" aria-label="close"><i class="fa fa-close"></i></a>

    <span class="pickup-msg"></span>

</div>
<form class="form-horizontal"  method="post" name="frm_edit_change_orders" id="frm_edit_change_orders" >
    <div class="panel panel-default">
        <div class="co-body">
            <div class="panel-body  col-md-12">
                <div class="panel-heading">
                    <h3 class="panel-title" style="text-transform: capitalize">change Order</h3>
                </div>
                <div class="alert alert-danger alert-dismissable amount-failed hide-el" style="display: none;">

                    <a href="#" class="close close-msg" data-dismiss="alert" aria-label="close"><i class="fa fa-close"></i></a>

                    <span class="amount-msg"></span>

                </div>
                <div style="margin-top: 60px;">
                    
                    <div class="form-group ch_amount">
                        <label class="col-md-3">Denominations:</label>
                        <div class="col-md-4">
                            
                            <div class='col-md-12 co_calculation'>
                                <label class="col-md-2">$50:</label>
                                <input type='hidden' value='50' class='change_co_amt'/>
                                <div class='col-md-8'>
                                    <input type="number" class="form-control pickup_amt" id="amt_d_50" name="change[0][amt_d_50]"/>
                                </div>
                                <label class="col-md-2 sub_amt"></label>
                                <input type="hidden" class="sub_amoumt"/>
                            </div>
                            <div class='col-md-12 co_calculation'>
                                <label class="col-md-2">$20:</label>
                                <input type='hidden' value='20' class='change_co_amt'/>
                                <div class='col-md-8'>
                                    <input type="number" class=" form-control pickup_amt" id="amt_d_20" name="change[0][amt_d_20]"/>
                                </div>
                                <label class="col-md-2 sub_amt"></label>
                                <input type="hidden" class="sub_amoumt"/>
                            </div>
                            
                            <div class='col-md-12 co_calculation'>
                                <label class="col-md-2">$10:</label>
                                <input type='hidden' value='10' class='change_co_amt'/>
                                <div class='col-md-8'>
                                    <input type="number" class=" form-control pickup_amt" id="amt_d_10" name="change[0][amt_d_10]"/>
                                </div>
                                <label class="col-md-2 sub_amt"></label>
                                <input type="hidden" class="sub_amoumt"/>
                            </div>
                            <div class='col-md-12 co_calculation'>
                                <label class="col-md-2">$5:</label>
                                <input type='hidden' value='5' class='change_co_amt'/>
                                <div class='col-md-8'>
                                    <input type="number" class=" form-control pickup_amt" id="amt_d_5" name="change[0][amt_d_5]"/>
                                </div>
                                <label class="col-md-2 sub_amt"></label>
                                <input type="hidden" class="sub_amoumt"/>
                            </div>
                            <div class='col-md-12 co_calculation'>
                                <label class="col-md-2">$1:</label>
                                <input type='hidden' value='1' class='change_co_amt'/>
                                <div class='col-md-8'>
                                    <input type="number"  class=" form-control pickup_amt" id="amt_d_1" name="change[0][amt_d_1]"/>
                                </div>
                                <label class="col-md-2 sub_amt"></label>
                                <input type="hidden" class="sub_amoumt"/>
                            </div>
                            <div class='col-md-12'>
                                <label class="col-md-2">Total:</label>
                                <label class="col-md-10 total_cost">0.00</label>
                                <input type="hidden" class="sub_total_amoumt"/>
                            </div>
                            <span class="help-block"></span>
                        </div>
                        <div class="col-md-4">
                            <div class='col-md-12 co_cent_calculation'>
                                <label class="col-md-2">1¢:</label>
                                <input type='hidden' value='1' class='change_co_cent_amt'/>
                                <div class='col-md-8'>
                                    <input type="number" class=" form-control pickup_cent_amt" id="amt_c_1" name="change[0][amt_c_1]"/>
                                </div>
                                <label class="col-md-2 sub_cent_amt"></label>
                                <input type="hidden" class="sub_cent_amoumt"/>
                            </div>
                            <div class='col-md-12 co_cent_calculation'>
                                <label class="col-md-2">5¢:</label>
                                <input type='hidden' value='5' class='change_co_cent_amt'/>
                                <div class='col-md-8'>
                                    <input type="number"  class=" form-control pickup_cent_amt" id="amt_c_5" name="change[0][amt_c_5]"/>
                                </div>
                                <label class="col-md-2 sub_cent_amt"></label>
                                <input type="hidden" class="sub_cent_amoumt"/>
                            </div>
                            <div class='col-md-12 co_cent_calculation'>
                                <label class="col-md-2">10¢:</label>
                                <input type='hidden' value='10' class='change_co_cent_amt'/>
                                <div class='col-md-8'>
                                    <input type="number"  class=" form-control pickup_cent_amt" id="amt_c_10" name="change[0][amt_c_10]"/>
                                </div>
                                <label class="col-md-2 sub_cent_amt"></label>
                                <input type="hidden" class="sub_cent_amoumt"/>
                            </div>
                            <div class='col-md-12 co_cent_calculation'>
                                <label class="col-md-2">25¢:</label>
                                <input type='hidden' value='25' class='change_co_cent_amt'/>
                                <div class='col-md-8'>
                                    <input type="number" class="form-control pickup_cent_amt" id="amt_c_25" name="change[0][amt_c_25]"/>
                                </div>
                                <label class="col-md-2 sub_cent_amt"></label>
                                <input type="hidden" class="sub_cent_amoumt"/>
                            </div>
                            <div class='col-md-12'>
                                <label class="col-md-2">Total:</label>
                                <label class="col-md-10 total_cent_cost">0.00</label>
                                <input type="hidden" class="sub_cent_total_amoumt"/>
                            </div>
                            <span class="help-block"></span>
                        </div>

                        <div class="form-group col-md-12">
                            <label class="col-md-3">Grand Total:</label>
                            <div class="col-md-9 grand_total">
                                0.00
                            </div>
                            <input type="hidden" class="gt_total_amoumt" value="0" name="change[0][gt_amt]"/>
                        </div>
                    </div>
                    <input type="hidden" name="pickup_id" id="pickup_id" />
                </div>
            </div>
        </div>
        <div class="panel-footer">  
            <button type="submit" class="btn btn-primary pull-right loader">Submit</button>
        </div>
    </div>
</form>