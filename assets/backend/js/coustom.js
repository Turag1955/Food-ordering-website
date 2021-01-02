function add_more() {
    var add_more_id = jQuery('#add_more_id').val();
    add_more_id++;
    jQuery('#add_more_id').val(add_more_id);
    var code = ' <div class="row ml-1" id="box ' + add_more_id + ' " ><div class="col-3"><div class="form-group">\n\
                        <label for="exampleInputName1">Attribute </label><input type="text" class="form-control" id="exampleInputName1" placeholder="Attribute  " name="attribute[]"   required=""> \n\
                       </div></div><div class="col-3"> <div class="form-group"> <label for="exampleInputName1">Price </label>\n\
                       <input type="text" class="form-control" id="exampleInputName1" placeholder="Price" name="price[]"   required=""> \n\
                       </div></div> <div class="col-3"><label for="">Status</label><select name="status[]" id="" class="form-control"><option>Select status</option><option value="1">Active</option><option value="0">Deactive</option></select></div> <div class="col-3"> <div class="form-group"> <br /> <button type="button" class="btn btn-danger mr-2" onclick=row_remove(" ' + add_more_id + ' ") >Remove</button>\n\
                       </div> </div> </div>';

    jQuery('#more').append(code);

}

function row_remove(id) {
    alert(id);
}
function db_row_remove(id) {
    var result = confirm('are you sure');
    if (result == true) {
        var url = window.location.href;
        window.location.href = url + "&details_id=" + id;
    }
}

function order_status_update(order_id){
    var order_status_id = jQuery('#order_status').val();
    if(order_status_id != ''){
        window.location.href = SITE_PATH_ADMIN+'order_details?id='+order_id+'&order_status='+order_status_id;
    }
    //alert(order_status_id);
}

function delivery_boy_select(order_id){
    var delivery_boy_id = jQuery('#delivery_boy').val();
    if(delivery_boy_id != ''){
        window.location.href = SITE_PATH_ADMIN+'order_details?id='+order_id+'&delivery_boy='+delivery_boy_id;
    }
    //alert(order_status_id);
}