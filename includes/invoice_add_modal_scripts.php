<script>



//
//
//helper functions
//
//

function updateProductTotal() {
      var price = parseFloat($("input[name='product-price']").val());
      var quantity = parseInt($("input[name='product-quantity']").val());
      
      if (!isNaN(price) && !isNaN(quantity)) {
          var total = price * quantity;
          $("input[name='product-total']").val(total.toFixed(2)); // Display total with 3 decimal places
      } else {
          $("input[name='product-total']").val('');
      }
      updateInvoiceTotals();
}


function updateItemTotal(sibling) {
    console.log("it changed")
    var $row = $(sibling).closest("tr");
    var $priceInput = $row.find(".item-price");
    var $quantityInput = $row.find(".item-quantity");
    var $totalInput = $row.find(".item-total"); // Corrected name
    var price = parseFloat($priceInput.val());
    var quantity = parseInt($quantityInput.val());

    if (!isNaN(price) && !isNaN(quantity)) {
        var total = price * quantity;
        $totalInput.val(total.toFixed(2)); // Display total with 3 decimal places
    } else {
        $totalInput.val('');
    }   
      updateInvoiceTotals();
}

 
function updateInvoiceTotals() {
      var total = 0;

      // Calculate the total based on item-total values
      $(".item-total").each(function () {
          var itemTotal = parseFloat($(this).val() || 0);
          total += itemTotal;
      });

      // Update final-invoice-total
      $("#final-invoice-total").html("<strong>SAR</strong> " + total.toFixed(2)); // Display total with 3 decimal places

      // Calculate and update final-invoice-vat
      var vat = total * 0.15; // Assuming VAT is 15%
      $("#final-invoice-vat").html("<strong>SAR</strong> " + vat.toFixed(2)); // Display VAT with 3 decimal places

      // Calculate and update final-invoice-total-with-vat
      var totalWithVat = total + vat;
      $("#final-invoice-total-with-vat").html("<strong>SAR</strong> " + totalWithVat.toFixed(2)); // Display total with VAT and 3 decimal places

      var AmountPaid = $("#reciept-payment-amount").val()
      var DueAmount =  AmountPaid - totalWithVat;

      $("#final-invoice-due-amount").html("<strong>SAR</strong> " + DueAmount.toFixed(2));
      
      if(DueAmount<0){
        $("#final-invoice-due-amount").css("color", "red");
      }else{
        $("#final-invoice-due-amount").css("color", "black");
      }


    }






$(document).ready(()=>{

    
//
//
//state trackers
//
//
$("select[name='product']").change(function () {
    // Get the selected option and its price
    var selectedOption = $("select[name='product'] option:selected");
    var price = parseFloat(selectedOption.attr("price"));

    // Set the price input value
    $("input[name='product-price']").val(price);

    // Update the total input value (price * quantity)
    updateProductTotal();
});

    // Attach change event handler to the quantity input
  
$("input[name='product-quantity']").change(function () {
    // Update the total input value (price * quantity)
    updateProductTotal();
});


$("input[name='product-price']").change(function () {
    // Update the total input value (price * quantity)
    updateProductTotal();
});



$("#invoice-items-body").on("change",".item-quantity",function(e){
    updateItemTotal($(this))
});

$("#invoice-items-body").on("change",".item-name",function(e){
    console.log("name changed")
    $(this).siblings(".product-id").remove();
});

$("#invoice-items-body").on("change",".item-price",function(e){
    updateItemTotal($(this))
});


$("#reciept-payment-amount").change(function(e){
    updateInvoiceTotals();
});

//
//
//click trackers
//
//
$("#add-invoice-item").click(function (e) {
    console.log("Button clicked");
   
    let product_name = $("select[name='product'] option:selected").text();
    let product_id = $("select[name='product'] option:selected").val();
    let product_quantity = $("input[name='product-quantity']").val();
    let product_price = $("input[name='product-price']").val();
    let product_total = $("input[name='product-total']").val();
    let numberOfRows = $("#invoice-items-body tr").length;

    var item_html = `
      <tr class="invoice-item">
        <td><div><input type="hidden" hidden value="${product_id}" class="form-control product-id" name="items[${numberOfRows}][product-id]"><input type="text" value="${product_name}" class="form-control item-name" name="items[${numberOfRows}][item-name]"></div></td>
        <td><div><input type="number" value="${product_quantity}" class="form-control col-md-2 item-quantity" min="0" name="items[${numberOfRows}][item-quantity]"></div></td>
        <td><div><input type="number" value="${product_price}" class="form-control col-md-2 price-input item-price" min="0" step="0.01" name="items[${numberOfRows}][item-price]"></div></td>
        <td><div><input type="number" value="${product_total}" class="form-control col-md-2 item-total" step="0.01" readonly name="items[${numberOfRows}][item-total]"></div></td>
        <td><div><a class="remove-invoice-item btn btn-danger form-control col-md-2"> <i class='fa fa-trash'></i> </a></div></td>
      </tr>
    `;
    
    var newItem = $(item_html);
    newItem.data("index", numberOfRows);
    $("#invoice-items-body").append(newItem);
    updateInvoiceTotals();
});

  
$("#invoice-items").on("click", ".remove-invoice-item", function (e) {
   
    let clicked_row = $(this).closest('.invoice-item');
    var removedIndex = clicked_row.data("index");
    clicked_row.remove();

    $(".invoice-item").each(function () {
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

    updateInvoiceTotals();
});

$("#create-invoice-button").click(function (e) {
  e.preventDefault(); // Prevent the default form submission behavior
  document.getElementById("invoice-add-form").submit(); // Submit the form
});
 

})
</script>