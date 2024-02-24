$(document).ready(function() {
    $('#s_class').prop('disabled', true);
    // Add change event listener to the first select

    $("#s_room").change(function() {
        $('#s_class').prop('disabled', false);

        var x = $("#s_room").val();
        // console.log(x);
        xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", "action.php?design=" + x, false);
        xmlhttp.send(null);
        $("#table").html(xmlhttp.responseText);
    });
    $('#s_class').select2();
    var selectedValues = [];

    $('#s_class').on('change', function() {
        selectedValues = $(this).val() || [];
        // console.log(selectedValues);
        load_strength(selectedValues);
        // load_strength(selectedValues);
        $.ajax({
            url: 'action.php',
            type: 'GET',
            data: {
                value: selectedValues
            },
            success: function(response) {
                $(".c_list").html(response);
            },
            error: function(xhr, status, error) {
                console.log("Error:", error);
            }
        });
    });


});

function load_strength(e) {
    var dataArray = [];
    console.log(e);
    $.ajax({
        url: "action.php",
        type: "POST",
        data: {
            e: e
        },
        dataType: "Text",
        success: function(response) {
            // console.log(response);
            $.each(JSON.parse(response), function(key, value) {
                // $("#c_name").val(value['class_name']);
                // $("#class_str").val(value['no_student']);
                // console.log(response);
                dataArray.push({
                    class_ID: value['class_ID'],
                    class_name: value['class_name'],
                    no_student: value['no_student']
                });
            });
            // console.log(dataArray.length);
            otherfunction(dataArray);
        }

    });
    // var data=dataArray.length;
    // console.log(data);
}

function otherfunction(data) {
    var total_class = data.length;
    var class_name = [];
    var class_id = [];
    var strength = [];
    var class_strength = [];
    $.each(data, function(index, element) {
        var rowCount = $('#tbody tr').length;
        // console.log("Number of rows in tbody: " + rowCount);
        console.log(element.class_ID);
        class_name.push(element.class_name);
        class_id.push(element.class_ID);
        strength.push(element.no_student);
        for (var i = 0; i < strength.length; i++) {
            window['class' + (i + 1)] = [];
            for (var j = 0; j < strength[i]; j++) {
                window['class' + (i + 1)].push(j + 1);
            }
        }

        // for (var k = 0; k < strength.length; k++) {
        //     console.log(window['class' + (k + 1)]);
        // }
        $(document).on('click', '.btn', function() {
            var id = $(this).attr('id');
            var num = id.split("-");
            var number = num[1];
            // let result = "values"+class_id;
            // console.log(result);
            $(document).off('click', '.dropdown-item');

            $(document).on('click', '.dropdown-item', function() {
                var a_id = $(this).attr('id');
                var a_value = $(this).data('value');
                console.log("ID:" + a_id);
                console.log("Value" + a_value);

                for (var f = 0; f < total_class; f++) {

                    console.log(window['class' + (f + 1)]);
                    if (a_id == class_name[f] && a_value == class_id[f]) {
                        for (var i = 1; i <= rowCount; i++) {
                            // var arr = [];
                            // arr.push(classes[i - 1].students);
                            $(".r-" + i + number).text(class_name[f] + "/- " + window['class' + (f + 1)][i-1]);

                            console.log(".r-" + i + number);
                        }
                        window['class'+(f+1)].splice(0,5);
                    }
                }

            });
        });
    });
}