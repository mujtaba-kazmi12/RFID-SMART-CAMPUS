// Jquery 

function BtnAdd() {
	var Tbody = $("#Tbody");
	var count = $("#Tbody tr").length;
	count++;
	// console.log(count);
	var Trow = $("#Trow_" + count);
	var newRow = '<tr id="Trow_' + count + '">' +
		'<td><a class="cut">-</a><input type="text" class="form-control border-0" name="id[]" id="id_' + count + '" onkeyup="BtnCheck(this)"></td>' +
		'<td><input type="text" class="form-control border-0" name="item[]" id="item_' + count + '"></td>' +
		'<td><input type="text" class="form-control border-0" name="description[]" id="description_' + count + '"></td>' +
		'<td><input type="text" class="form-control border-0" name="price[]" id="price_' + count + '"></td>' +
		'<td><input type="number" class="form-control border-0" value="1" name="quantity[]" id="quantity_' + count + '" onchange="calc(this)"></td>' +
		'<td><input type="text" class="form-control border-0" name="total[]" id="total_' + count + '"></td>' +
		'</tr>';
	Tbody.append(newRow);


}

$(document).ready(function () {
	// To load student details according to card number
	// var barcodeInput = $('#card_no');

	$("#card_no").on('keyup', function (event) {
		var id = $(card_no).val();
	if (id.length == 13) {
		console.log(id);
		$.ajax({
			url: "action.php",
			type: "POST",
			data: {
				"search": true,
				"id": id,
			},
			dataType: "Text",
			success: function (response) {
				try {
					$.each(JSON.parse(response), function (key, value) {
						$("#name").val(value['name']);
						$("#rollno").val(value['rollno']);
						$("#pno").val(value['pno']);
					});
				} catch (e) {
					alert('Not found');
				}
			}

		});
	}

	});

	$("#Tbody").on("click", ".cut", function () {
		$(this).closest("tr").remove();
	});

});
	
function BtnCheck(v) {
	var index = $(v).parent().parent().index();
	index++;
	// console.log(index);
	var id = $("#id_" + index).val();
	// console.log(id);
	$.ajax({
		url: "action.php",
		type: "POST",
		data: {
			"btn_search": true,
			"id": id,
		},
		dataType: "Text",
		success: function (response) {
			try {
				$.each(JSON.parse(response), function (key, value) {

					$("#id_" + index).val(value['id']);
					$("#item_" + index).val(value['item_name']);
					$("#description_" + index).val(value['description']);
					$("#price_" + index).val(value['price']);
					$("#total_" + index).val(value['price']);
				});
			} catch (e) {
				alert('Not found');
			}
		}
	});

}

function calc(v) {
	var index = $(v).parent().parent().index();
	index++;
	// console.log(index);
	var qty = $("#quantity_" + index).val();
	// console.log(qty);
	var price = $("#price_" + index).val();
	var amt = qty * price;
	// console.log(amt);
	$("#total_" + index).val(amt);
	GetTotal();
}

function GetTotal() {
	var rowCount = $("#Tbody tr").length;
	var sum = 0;
	for (var i = 1; i <= rowCount; i++) {
		var total_amount = $("#total_" + i).val();
		sum = (+sum) + (+total_amount);
	}
	$("#t_amount").val(sum);
}


