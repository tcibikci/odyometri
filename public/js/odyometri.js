$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var text_max = 255;
    $('#message').html("0 / " + text_max);

    $('#comment').keyup(function () {
        var text_length = $('#comment').val().length;
        if (text_length < 255) {
            $('#message').html(text_length + " / " + text_max);
            $('#message').addClass('text-black-50');
            $('#message').removeClass('text-danger');
        }
        else {
            $('#message').html(text_length + " / " + text_max);
            $('#message').addClass('text-danger');
            $('#message').removeClass('text-black-50');
        }
    });


    //Karşılaştırma modalı kapanırsa tabloyu sıfırla
    $('#comparisonModal').on('hidden.bs.modal', function () {
        console.log("Karşılaştırma Tablosu Sıfırlandı");
        $("#LeftEar > tbody").html("");
        $("#RightEar > tbody").html("");
    });


    //Tüm itemleri secme
    $("#selectAll").click(function () {

        //Tüm checkboxlar için
        $("input:checkbox").each(function () {
            //Eğer tümünü seç işaretli ise tüm checkboxları seç
            if ($('#selectAll').is(':checked')) {
                $('input:checkbox').not(this).prop('checked', this.checked);
            }
            else
                $('input:checkbox').not(this).prop('checked', false);


            //Itemler için background ayarla
            var $this = $(this);
            checkedItem($this.attr("id"));
        });
    });
});

//Odyometri bilgileri goruntuleme ve düzenleme
function editOdyometri(id) {
    $.ajax({
        url:  window.location.origin+"/getOdyometri",
        type: 'POST',
        data: {
            id: id,
        },
        success: function (result) {
            //Ajax ile gelen veriler inputlara atanıyor
            $("#editModal #id").val(result.id);
            $("#editModal #date").val(result.date);
            $("#editModal #comment").val(result.comment);

            $("#editModal #L250hz").val(result.L250hz);
            $("#editModal #L500hz").val(result.L500hz);
            $("#editModal #L1khz").val(result.L1khz);
            $("#editModal #L2khz").val(result.L2khz);
            $("#editModal #L3khz").val(result.L3khz);
            $("#editModal #L4khz").val(result.L4khz);
            $("#editModal #L6khz").val(result.L6khz);
            $("#editModal #L8khz").val(result.L8khz);
            $("#editModal #LSSO").val(result.LSSO);

            $("#editModal #R250hz").val(result.R250hz);
            $("#editModal #R500hz").val(result.R500hz);
            $("#editModal #R1khz").val(result.R1khz);
            $("#editModal #R2khz").val(result.R2khz);
            $("#editModal #R3khz").val(result.R3khz);
            $("#editModal #R4khz").val(result.R4khz);
            $("#editModal #R6khz").val(result.R6khz);
            $("#editModal #R8khz").val(result.R8khz);
            $("#editModal #RSSO").val(result.RSSO);

        },
        error: function (result) {
            alert('İşlem sırasında bir sorun meydana geldi');
        }
    });

}

//Seçilen itemlerin background u değiştiriliyor
function checkedItem(id) {
    listItem = "List" + id;
    $('#' + listItem).addClass('bg-warning');

    if ($('#' + id).is(':checked')) {
        listItem = "List" + id;
        $('#' + listItem).addClass('bg-warning');
    }
    else {
        listItem = "List" + id;
        $('#' + listItem).removeClass('bg-warning');
    }
}

//Karşılaştırma işlemleri
function comparison() {

    //seçilmiş itemlerin id lerini alıyor
    var checkkedItem = [];
    $('input[type=checkbox]').each(function () {
        if (this.checked) {
            checkkedItem.push($(this).attr('id'));
        }
    });

    //Karşılaştırma için en az 2 item seçilmiş mi bakıyor
    if (checkkedItem.length <= 1) {
        alert("Karşılaştırma işlemi için en az 2 item seçmeniz gerekiyor.");
    }
    else {

        $.ajax({
            url: window.location.origin+"/getOdyometris",
            type: 'POST',
            data: {
                id: checkkedItem,
            },
            success: function (result) {
                $("#comparisonModal").modal('show');

                /*--LEFT EAR--*/
                //Ajax ile gelen veriler tabloda yerine ekleniyor.
                var totalRow = 0;
                $.each(result, function (key, value) {
                    var $row = $('<tr>' +
                        '<td>' + value.date + '</td>' +
                        '<td>' + value.L250hz + '</td>' +
                        '<td>' + value.L500hz + '</td>' +
                        '<td>' + value.L1khz + '</td>' +
                        '<td>' + value.L2khz + '</td>' +
                        '<td>' + value.L3khz + '</td>' +
                        '<td>' + value.L4khz + '</td>' +
                        '<td>' + value.L6khz + '</td>' +
                        '<td>' + value.L8khz + '</td>' +
                        '<td>' + value.LSSO + '</td>' +
                        '</tr>');
                    $('#LeftEar > tbody:last').append($row);
                    $('#days').text((key + 1) + " Gün");
                    totalRow = key; // Toplam  gün sayısı alındı
                });

                //Ekli olan günlerden değerleri alıp farklar hesaplanıyor
                for (i = 0; i <= totalRow; i++) {
                    //İlk defa çalışıyorsa ilk değişken ataması yapılıyor
                    if (i === 0) {
                        var x250hz = $("#LeftEar > tbody > tr:eq(" + i + ")").find('td:eq(1)').text();
                        var x500hz = $("#LeftEar > tbody > tr:eq(" + i + ")").find('td:eq(2)').text();
                        var x1khz = $("#LeftEar > tbody > tr:eq(" + i + ")").find('td:eq(3)').text();
                        var x2khz = $("#LeftEar > tbody > tr:eq(" + i + ")").find('td:eq(4)').text();
                        var x3khz = $("#LeftEar > tbody > tr:eq(" + i + ")").find('td:eq(5)').text();
                        var x4khz = $("#LeftEar > tbody > tr:eq(" + i + ")").find('td:eq(6)').text();
                        var x6khz = $("#LeftEar > tbody > tr:eq(" + i + ")").find('td:eq(7)').text();
                        var x8khz = $("#LeftEar > tbody > tr:eq(" + i + ")").find('td:eq(8)').text();
                        var xSSO = $("#LeftEar > tbody > tr:eq(" + i + ")").find('td:eq(9)').text();
                    }
                    else {
                        //Eski değerlerden yeni gelenler çıkartılıp değişkenlere aktarılıyor
                        var x250hz = x250hz - $("#LeftEar > tbody > tr:eq(" + i + ")").find('td:eq(1)').text();
                        var x500hz = x500hz - $("#LeftEar > tbody > tr:eq(" + i + ")").find('td:eq(2)').text();
                        var x1khz = x1khz - $("#LeftEar > tbody > tr:eq(" + i + ")").find('td:eq(3)').text();
                        var x2khz = x2khz - $("#LeftEar > tbody > tr:eq(" + i + ")").find('td:eq(4)').text();
                        var x3khz = x3khz - $("#LeftEar > tbody > tr:eq(" + i + ")").find('td:eq(5)').text();
                        var x4khz = x4khz - $("#LeftEar > tbody > tr:eq(" + i + ")").find('td:eq(6)').text();
                        var x6khz = x6khz - $("#LeftEar > tbody > tr:eq(" + i + ")").find('td:eq(7)').text();
                        var x8khz = x8khz - $("#LeftEar > tbody > tr:eq(" + i + ")").find('td:eq(8)').text();
                        var xSSO = xSSO - $("#LeftEar > tbody > tr:eq(" + i + ")").find('td:eq(9)').text();

                    }
                }

                //Hesaplanması biten fark verileri tabloda farklar yerine atanıyor
                if (x250hz <= 0)
                    $('#difL250hz').html("<label class='text-success'>" + x250hz + "<i class='fa fa-arrow-up'></i></label>");
                else
                    $('#difL250hz').html("<label class='text-danger'>" + x250hz + "<i class='fa fa-arrow-down'></i></label>");

                if (x500hz <= 0)
                    $('#difL500hz').html("<label class='text-success'>" + x500hz + "<i class='fa fa-arrow-up'></i></label>");
                else
                    $('#difL500hz').html("<label class='text-danger'>" + x500hz + "<i class='fa fa-arrow-down'></i></label>");

                if (x1khz <= 0)
                    $('#difL1khz').html("<label class='text-success'>" + x1khz + "<i class='fa fa-arrow-up'></i></label>");
                else
                    $('#difL1khz').html("<label class='text-danger'>" + x1khz + "<i class='fa fa-arrow-down'></i></label>");

                if (x2khz <= 0)
                    $('#difL2khz').html("<label class='text-success'>" + x2khz + "<i class='fa fa-arrow-up'></i></label>");
                else
                    $('#difL2khz').html("<label class='text-danger'>" + x2khz + "<i class='fa fa-arrow-down'></i></label>");

                if (x3khz <= 0)
                    $('#difL3khz').html("<label class='text-success'>" + x3khz + "<i class='fa fa-arrow-up'></i></label>");
                else
                    $('#difL3khz').html("<label class='text-danger'>" + x3khz + "<i class='fa fa-arrow-down'></i></label>");

                if (x4khz <= 0)
                    $('#difL4khz').html("<label class='text-success'>" + x4khz + "<i class='fa fa-arrow-up'></i></label>");
                else
                    $('#difL4khz').html("<label class='text-danger'>" + x4khz + "<i class='fa fa-arrow-down'></i></label>");

                if (x6khz <= 0)
                    $('#difL6khz').html("<label class='text-success'>" + x6khz + "<i class='fa fa-arrow-up'></i></label>");
                else
                    $('#difL6khz').html("<label class='text-danger'>" + x6khz + "<i class='fa fa-arrow-down'></i></label>");

                if (x8khz <= 0)
                    $('#difL8khz').html("<label class='text-success'>" + x8khz + "<i class='fa fa-arrow-up'></i></label>");
                else
                    $('#difL8khz').html("<label class='text-danger'>" + x8khz + "<i class='fa fa-arrow-down'></i></label>");

                if (xSSO <= 0)
                    $('#difLSSO').html("<label class='text-success'>" + xSSO + "<i class='fa fa-arrow-up'></i></label>");
                else
                    $('#difLSSO').html("<label class='text-danger'>" + xSSO + "<i class='fa fa-arrow-down'></i></label>");

                /*--END OF LEFT EAR--*/

                /*--RIGHT EAR--*/

                //Ajax ile gelen veriler tabloda yerine ekleniyor.
                totalRow = 0;
                $.each(result, function (key, value) {
                    var $row = $('<tr>' +
                        '<td>' + value.date + '</td>' +
                        '<td>' + value.R250hz + '</td>' +
                        '<td>' + value.R500hz + '</td>' +
                        '<td>' + value.R1khz + '</td>' +
                        '<td>' + value.R2khz + '</td>' +
                        '<td>' + value.R3khz + '</td>' +
                        '<td>' + value.R4khz + '</td>' +
                        '<td>' + value.R6khz + '</td>' +
                        '<td>' + value.R8khz + '</td>' +
                        '<td>' + value.RSSO + '</td>' +
                        '</tr>');
                    $('#RightEar > tbody:last').append($row);
                    $('#RightDays').text((key + 1) + " Gün");
                    totalRow = key; // Toplam  gün sayısı alındı
                });

                //Ekli olan günlerden değerleri alıp farklar hesaplanıyor
                for (i = 0; i <= totalRow; i++) {
                    //İlk defa çalışıyorsa ilk değişken ataması yapılıyor
                    if (i === 0) {
                        var y250hz = $("#RightEar > tbody > tr:eq(" + i + ")").find('td:eq(1)').text();
                        var y500hz = $("#RightEar > tbody > tr:eq(" + i + ")").find('td:eq(2)').text();
                        var y1khz = $("#RightEar > tbody > tr:eq(" + i + ")").find('td:eq(3)').text();
                        var y2khz = $("#RightEar > tbody > tr:eq(" + i + ")").find('td:eq(4)').text();
                        var y3khz = $("#RightEar > tbody > tr:eq(" + i + ")").find('td:eq(5)').text();
                        var y4khz = $("#RightEar > tbody > tr:eq(" + i + ")").find('td:eq(6)').text();
                        var y6khz = $("#RightEar > tbody > tr:eq(" + i + ")").find('td:eq(7)').text();
                        var y8khz = $("#RightEar > tbody > tr:eq(" + i + ")").find('td:eq(8)').text();
                        var ySSO = $("#RightEar > tbody > tr:eq(" + i + ")").find('td:eq(9)').text();
                    }
                    else {
                        //Eski değerlerden yeni gelenler çıkartılıp değişkenlere aktarılıyor
                        var y250hz = y250hz - $("#RightEar > tbody > tr:eq(" + i + ")").find('td:eq(1)').text();
                        var y500hz = y500hz - $("#RightEar > tbody > tr:eq(" + i + ")").find('td:eq(2)').text();
                        var y1khz = y1khz - $("#RightEar > tbody > tr:eq(" + i + ")").find('td:eq(3)').text();
                        var y2khz = y2khz - $("#RightEar > tbody > tr:eq(" + i + ")").find('td:eq(4)').text();
                        var y3khz = y3khz - $("#RightEar > tbody > tr:eq(" + i + ")").find('td:eq(5)').text();
                        var y4khz = y4khz - $("#RightEar > tbody > tr:eq(" + i + ")").find('td:eq(6)').text();
                        var y6khz = y6khz - $("#RightEar > tbody > tr:eq(" + i + ")").find('td:eq(7)').text();
                        var y8khz = y8khz - $("#RightEar > tbody > tr:eq(" + i + ")").find('td:eq(8)').text();
                        var ySSO = ySSO - $("#RightEar > tbody > tr:eq(" + i + ")").find('td:eq(9)').text();

                    }
                }

                //Hesaplanması biten fark verileri tabloda farklar yerine atanıyor
                if (y250hz <= 0)
                    $('#difR250hz').html("<label class='text-success'>" + y250hz + "<i class='fa fa-arrow-up'></i></label>");
                else
                    $('#difR250hz').html("<label class='text-danger'>" + y250hz + "<i class='fa fa-arrow-down'></i></label>");

                if (y500hz <= 0)
                    $('#difR500hz').html("<label class='text-success'>" + y500hz + "<i class='fa fa-arrow-up'></i></label>");
                else
                    $('#difR500hz').html("<label class='text-danger'>" + y500hz + "<i class='fa fa-arrow-down'></i></label>");

                if (y1khz <= 0)
                    $('#difR1khz').html("<label class='text-success'>" + y1khz + "<i class='fa fa-arrow-up'></i></label>");
                else
                    $('#difR1khz').html("<label class='text-danger'>" + y1khz + "<i class='fa fa-arrow-down'></i></label>");

                if (y2khz <= 0)
                    $('#difR2khz').html("<label class='text-success'>" + y2khz + "<i class='fa fa-arrow-up'></i></label>");
                else
                    $('#difR2khz').html("<label class='text-danger'>" + y2khz + "<i class='fa fa-arrow-down'></i></label>");

                if (y3khz <= 0)
                    $('#difR3khz').html("<label class='text-success'>" + y3khz + "<i class='fa fa-arrow-up'></i></label>");
                else
                    $('#difR3khz').html("<label class='text-danger'>" + y3khz + "<i class='fa fa-arrow-down'></i></label>");

                if (y4khz <= 0)
                    $('#difR4khz').html("<label class='text-success'>" + y4khz + "<i class='fa fa-arrow-up'></i></label>");
                else
                    $('#difR4khz').html("<label class='text-danger'>" + y4khz + "<i class='fa fa-arrow-down'></i></label>");

                if (y6khz <= 0)
                    $('#difR6khz').html("<label class='text-success'>" + y6khz + "<i class='fa fa-arrow-up'></i></label>");
                else
                    $('#difR6khz').html("<label class='text-danger'>" + y6khz + "<i class='fa fa-arrow-down'></i></label>");

                if (y8khz <= 0)
                    $('#difR8khz').html("<label class='text-success'>" + y8khz + "<i class='fa fa-arrow-up'></i></label>");
                else
                    $('#difR8khz').html("<label class='text-danger'>" + y8khz + "<i class='fa fa-arrow-down'></i></label>");

                if (ySSO <= 0)
                    $('#difRSSO').html("<label class='text-success'>" + ySSO + "<i class='fa fa-arrow-up'></i></label>");
                else
                    $('#difRSSO').html("<label class='text-danger'>" + ySSO + "<i class='fa fa-arrow-down'></i></label>");



                /*--END OF RIGHT EAR--*/


            },
            error: function (result) {
                alert('Karşılaştırma işlemin de bir hata oluştu');
            }
        });
    }
}

//Item goruntuleme
function showItem(id) {
    $.ajax({
        url: window.location.origin+"/getOdyometri",
        type: 'POST',
        data: {
            id: id,
        },
        success: function (result) {
            $("#showModal").modal('show');
            //Ajax ile gelen veriler inputlara atanıyor
            $("#showModal #date").val(result.date);
            $("#showModal #comment").val(result.comment);

            $("#showModal #L250hz").val(result.L250hz);
            $("#showModal #L500hz").val(result.L500hz);
            $("#showModal #L1khz").val(result.L1khz);
            $("#showModal #L2khz").val(result.L2khz);
            $("#showModal #L3khz").val(result.L3khz);
            $("#showModal #L4khz").val(result.L4khz);
            $("#showModal #L6khz").val(result.L6khz);
            $("#showModal #L8khz").val(result.L8khz);
            $("#showModal #LSSO").val(result.LSSO);

            $("#showModal #R250hz").val(result.R250hz);
            $("#showModal #R500hz").val(result.R500hz);
            $("#showModal #R1khz").val(result.R1khz);
            $("#showModal #R2khz").val(result.R2khz);
            $("#showModal #R3khz").val(result.R3khz);
            $("#showModal #R4khz").val(result.R4khz);
            $("#showModal #R6khz").val(result.R6khz);
            $("#showModal #R8khz").val(result.R8khz);
            $("#showModal #RSSO").val(result.RSSO);

        },
        error: function (result) {
            alert('İşlem sırasında bir sorun meydana geldi');
        }
    });
}

//Item silme
function deleteItem(id) {
    $.ajax({
        url: window.location.origin+"/delete",
        type: 'POST',
        data: {
            id: id,
        },
        success: function (result) {
            $('#List' + id).remove();
            alert('Item Silindi');

        },
        error: function (result) {
            alert('İşlem sırasında bir sorun meydana geldi');
        }
    });

}
