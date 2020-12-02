// jquery

$(function () { //load
    var activeNote = 0;
    var editMode = false;
    // ajax call to loadnotes.php
    $.ajax({
        url: "loadnotes.php",
        success: function (data) {

            $('#notes').html(data);
            clickonNote();
            clickonDelete();
        },
        error: function () {
            $('#alertContent').text("Error in Ajax Call. Please try again later");
            $('#alert').fadeIn();
        }
    });

    $("#addNote").click(function () {
        $.ajax({
            url: "createnote.php",
            success: function (data) {
                if (data == 'error') {
                    $('#alertContent').text("There was issue inserting new Note");
                    $('#alert').fadeIn();
                } else {
                    activeNote = data;
                    $('textarea').val('');
                    showHide(['#notepad', '#allNotes'], ['#notes', '#addNote', '#edit', '#done']);
                    $('textarea').focus();
                }
            },
            error: function () {
                $('#alertContent').html("Error in Ajax Call. Please try again later");
                $('#alert').fadeIn();
            }
        });
    })

    // click on allnotes button
    $('#allNotes').click(function () {
        $.ajax({
            url: "loadnotes.php",
            success: function (data) {
                $('#notes').html(data);
                showHide(['#addNote', '#edit', '#notes'], ['#allNotes', '#notepad']);
                clickonNote();
                clickonDelete();
            },
            error: function () {
                $('#alertContent').html("Error in Ajax Call. Please try again later");
                $('#alert').fadeIn();
            }
        });
    })

    // updatenote or write note
    $('textarea').keyup(function () {
        // ajax call to update the task of id activenote
        $.ajax({
            url: "updatenote.php",
            type: "POST",
            // we need to send current note content to php file with its id
            data: {
                note: $(this).val(),
                id: activeNote
            },
            success: function (data) {
                if (data == 'error') {
                    $('#alertContent').html("Issue updating the notes in database.");
                    $('#alert').fadeIn();
                }
            },
            error: function () {
                $('#alertContent').html("Error in Ajax Call. Please try again later");
                $('#alert').fadeIn();
            }

        })

    })
    // edit button
    $("#edit").click(function (e) {
        e.preventDefault();

        editMode = true;
        $('.notesheader').addClass("col-xs-7 col-sm-7 col-lg-9");
        showHide(['#done', '.delete'], [this]);
    });


    // done button
    $("#done").click(function (e) {
        e.preventDefault();

        editMode = false;

        $('.notesheader').removeClass("col-xs-7 col-sm-7 col-lg-9");
        showHide(['#edit'], [this, '.delete']);
    });



    // functions
    function showHide(array1, array2) {
        for (let i = 0; i < array1.length; i++) {
            $(array1[i]).show();
        }
        for (let i = 0; i < array2.length; i++) {
            $(array2[i]).hide();
        }
    }

    function clickonNote() {
        $('.notesheader').click(function () {
            if (!editMode) {
                // update activenote variable to id of note
                activeNote = $(this).attr("id");
                // fill text area
                $("textarea").val($(this).find('.text').text());
                // show hide elements
                showHide(['#notepad', '#allNotes'], ['#notes', '#addNote', '#edit', '#done']);
                $('textarea').focus();
            }
        })
    }

    // click on delete
    function clickonDelete() {
        $('.delete').click(function () {
            var deleteButton = $(this);
            $.ajax({
                url: "deletenote.php",
                type: "POST",

                data: {
                    id: deleteButton.next().attr("id")
                },
                success: function (data) {
                    if (data == 'error') {
                        $('#alertContent').html("Issue deleting the notes from database.");
                        $('#alert').fadeIn();
                    } else {
                        // remove containing div
                        deleteButton.parent().remove();
                    }
                },
                error: function () {
                    $('#alertContent').html("Error in Ajax Call. Please try again later");
                    $('#alert').fadeIn();
                }

            })
        })
    }

})