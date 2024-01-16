<script>

//
//
//helper functions
//
//

function updateEditProductTotal() {
      var price = parseFloat($("input[name='edit-product-price']").val());
      var quantity = parseInt($("input[name='edit-product-quantity']").val());
      
      if (!isNaN(price) && !isNaN(quantity)) {
          var total = price * quantity;
          $("input[name='edit-product-total']").val(total.toFixed(2)); // Display total with 3 decimal places
      } else {
          $("input[name='edit-product-total']").val('');
      }
      updateEditInvoiceTotals();
}


function updateEditItemTotal(sibling) {
    console.log("it changed")
    var $row = $(sibling).closest("tr");
    var $priceInput = $row.find(".edit-item-price");
    var $quantityInput = $row.find(".edit-item-quantity");
    var $totalInput = $row.find(".edit-item-total"); // Corrected name
    var price = parseFloat($priceInput.val());
    var quantity = parseInt($quantityInput.val());

    if (!isNaN(price) && !isNaN(quantity)) {
        var total = price * quantity;
        $totalInput.val(total.toFixed(2)); // Display total with 3 decimal places
    } else {
        $totalInput.val('');
    }   
      updateEditInvoiceTotals();
}

 
function updateEditInvoiceTotals() {
      var total = 0;

      // Calculate the total based on item-total values
      $(".edit-item-total").each(function () {
          var itemTotal = parseFloat($(this).val() || 0);
          total += itemTotal;
      });

      // Update final-invoice-total
      $("#edit-final-invoice-total").html("<strong>SAR</strong> " + total.toFixed(2)); // Display total with 3 decimal places

      // Calculate and update final-invoice-vat
      var vat = total * 0.15; // Assuming VAT is 15%
      $("#edit-final-invoice-vat").html("<strong>SAR</strong> " + vat.toFixed(2)); // Display VAT with 3 decimal places

      // Calculate and update final-invoice-total-with-vat
      var totalWithVat = total + vat;
      $("#edit-final-invoice-total-with-vat").html("<strong>SAR</strong> " + totalWithVat.toFixed(2)); // Display total with VAT and 3 decimal places

      var AmountPaid = $("#edit-reciept-payment-amount").val()
      var DueAmount =  AmountPaid - totalWithVat;

      $("#edit-final-invoice-due-amount").html("<strong>SAR</strong> " + DueAmount.toFixed(2));
      
      if(DueAmount<0){
        $("#edit-final-invoice-due-amount").css("color", "red");
      }else{
        $("#edit-final-invoice-due-amount").css("color", "black");
      }

}





$(document).ready(()=>{


var selectedOption = $("select[name='edit-product'] option:selected");
var price = parseFloat(selectedOption.attr("price"));

// Set the price input value
$("input[name='edit-product-price']").val(price);

// Update the total input value (price * quantity)
updateEditProductTotal();
   



//
//
//state trackers
//
//
$("select[name='edit-product']").change(function () {
    // Get the selected option and its price
    var selectedOption = $("select[name='edit-product'] option:selected");
    var price = parseFloat(selectedOption.attr("price"));

    // Set the price input value
    $("input[name='edit-product-price']").val(price);

    // Update the total input value (price * quantity)
    updateEditProductTotal();
});

    // Attach change event handler to the quantity input
  
$("input[name='edit-product-quantity']").change(function () {
    // Update the total input value (price * quantity)
    updateEditProductTotal();
});


$("input[name='edit-product-price']").change(function () {
    // Update the total input value (price * quantity)
    updateEditProductTotal();
});
 
$("#edit-invoice-items-body").on("change",".edit-item-quantity",function(e){
    updateEditItemTotal($(this))
});

$("#edit-invoice-items-body").on("change",".edit-item-name",function(e){
    console.log("name changed")
    $(this).siblings(".edit-product-id").remove();
});

$("#edit-invoice-items-body").on("change",".edit-item-price",function(e){
    updateEditItemTotal($(this))
});




//
//
//click trackers
//
//
$("#add-edit-invoice-item").click(function (e) {
    console.log("Button clicked");
   
    let product_name = $("select[name='edit-product'] option:selected").text();
    let product_id = $("select[name='edit-product'] option:selected").val();
    let product_quantity = $("input[name='edit-product-quantity']").val();
    let product_price = $("input[name='edit-product-price']").val();
    let product_total = $("input[name='edit-product-total']").val();
    let numberOfRows = $("#edit-invoice-items-body tr").length;

    var item_html = `
      <tr class="edit-invoice-item">
        <td><div><input type="hidden" hidden value="${product_id}" class="form-control edit-product-id" name="items[${numberOfRows}][product-id]"><input type="text" value="${product_name}" class="form-control edit-item-name" name="items[${numberOfRows}][item-name]"></div></td>
        <td><div><input type="number" value="${product_quantity}" class="form-control col-md-2 edit-item-quantity" min="0" name="items[${numberOfRows}][item-quantity]"></div></td>
        <td><div><input type="number" value="${product_price}" class="form-control col-md-2 price-input edit-item-price" min="0" step="0.01" name="items[${numberOfRows}][item-price]"></div></td>
        <td><div><input type="number" value="${product_total}" class="form-control col-md-2 edit-item-total" step="0.01" readonly name="items[${numberOfRows}][item-total]"></div></td>
        <td><div><a class="remove-edit-invoice-item btn btn-danger form-control col-md-2"> <i class='fa fa-trash'></i> </a></div></td>
      </tr>
    `;
    
    var newItem = $(item_html);
    newItem.data("index", numberOfRows);
    $("#edit-invoice-items-body").append(newItem);
    updateEditInvoiceTotals();
});

  
$("#edit-invoice-items").on("click", ".remove-edit-invoice-item", function (e) {
   
    let clicked_row = $(this).closest('.edit-invoice-item');
    var removedIndex = clicked_row.data("index");
    clicked_row.remove();

    $(".edit-invoice-item").each(function () {
        var currentIndex = $(this).data("index");
        if (currentIndex > removedIndex) {
            currentIndex--;
            $(this).data("index", currentIndex);
            // Update the name attributes of input fields
            $(this).find("input[name^='items']").each(function () {
                var newName = $(this).attr("name").replace(/\[(\d+)\]/, "[" + currentIndex + "]");
                $(this).attr("name", newName);
            });
        }
    });

    updateEditInvoiceTotals();
});

$("#edit-invoice-submit-button").click(function (e) {
  e.preventDefault(); // Prevent the default form submission behavior
  document.getElementById("invoice-edit-form").submit(); // Submit the form
});
 

})
</script>