$(document).ready(function(){
    $('#modal_partage').modal({
        show: 'false'
    });
}
 
)

$(document).on("click",".portager", function () {
    $("#modal_partage").modal('show');
    partage(this);

})


function partage(object){
    donnes_id = $(object).closest("tr").find(".portager").val();
    console.log(donnes_id);
    $("#note_id").val(donnes_id);
};



$(document).on("click",".editClass", function () {
    edit(this);

    })
    
    function edit(object){
        $(object).addClass("d-none");
        $(object).closest("tr").find(".editConfirmClass").removeClass("d-none")
        $(object).closest("tr").find(".note").prop('readonly', false);
    };



$(document).on("click",".editConfirmClass", function () {

    confirmEdit(this);


    })

    function confirmEdit(object){
        $(object).addClass("d-none");
        $(object).closest("tr").find(".editClass").removeClass("d-none")
        $(object).closest("tr").find(".note").prop('readonly', true);
    };




