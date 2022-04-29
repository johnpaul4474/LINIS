// var index = 1;
// function addfield(){
//     var item_name = $('.item_name').html();
//     var tr = '<tr><td> <div> <input list="raw_mat['+index+']" class="form-control" name="raw_mat['+index+']" required> <datalist id="raw_mat['+index+']"> @foreach ($Raw as $item) <option value="{{$item->id}}"> {{$item->item_name}} </option> @endforeach  </datalist> </div> </td> <td> <div> <input id="item_name['+index+']" type="text" name="item_name['+index+']" class="form-control" required> </div> </td> <td> <div> <input id="item_unit['+index+']" type="text" name="item_unit['+index+']" class="form-control"> </div> </td> <td> <div> <input id="item_qty['+index+']" type="number" name="item_qty['+index+']" class="form-control"> </div> </td> <td> <div> <input id="item_price['+index+']" type="number" name="item_price['+index+']" class="form-control"> </div> </td> <td> <div> <input id="date_created['+index+']" type="date" name="date_created['+index+']" class="form-control"> </div> </td><td><input type="button" class="btn btn-danger delete" onclick="deletefield()" value="X"></td></tr>';

        
//     index++;
//     console.log('Add People Involved index : ' + index);
//     $('.addfinishmatsbody').append(tr);

// }

$(document).ready(function() {
    var a = 0;
    $(document).on("click", "#clonebtn",function() {
        // alert("test");
        $('#clone2').clone().appendTo($('#clone'));
        $('#material_used').attr("name", "material_used"+a);
        $('#item_name').attr("name", "item_name"+a);
        $('#item_unit').attr("name", "item_unit"+a);
        $('#item_qty').attr("name", "item_qty"+a);
        $('#item_price').attr("name", "item_price"+a);
        $('#date_created').attr("name", "date_created"+a);
        a++;
    });
    
    $(document).on("click", "#clonedel",function() {
      $(this).parent().parent().remove();
        
    });

    
});


function deletefield(){
$('.addfinishmatsbody').delegate('.delete', 'click', function(){
    $(this).parent().parent().remove();
});
}



                        // <td>
                        //     <div>
                        //         <input list="raw_mat" class="form-control" name="raw_mat" required>
                        //         <datalist id="raw_mat">
                        //             @foreach ($Raw as $item)
                        //                 <option value="{{$item->item_name}}">
                        //             @endforeach 
                        //         </datalist> 
                        //     </div>
                        // </td>

                        // <td>
                        //     <div>
                        //         <input id="item_name[0]" type="text" name="item_name[0]" class="form-control" required>
                        //     </div>
                        // </td>

                        // <td>
                        //     <div>
                        //         <input id="item_unit[0]" type="text" name="item_unit[0]" class="form-control" required>
                        //     </div>
                        // </td>

                        // <td>
                        //     <div>
                        //         <input id="item_qty[0]" type="number" name="item_qty[0]" class="form-control">
                        //     </div>
                        // </td>

                        // <td>
                        //     <div>
                        //         <input id="item_price[0]" type="number" name="item_price[0]" class="form-control">
                        //     </div>
                        // </td>

                        // <td>
                        //     <div>
                        //         <input id="date_created[0]" type="date" name="date_created[0]" class="form-control">
                        //     </div>
                        // </td>