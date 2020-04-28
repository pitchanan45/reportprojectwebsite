$('#strategyAddSubmit').click(function(){
    $('#strategyAddForm').submit();
});

$('#strategyEditSubmit').click(function(){
    $('#strategyEditForm').submit();
});

$('#projectAddSubmit').click(function(){
    $('#projectAddForm').submit();
});

$('#projectEditSubmit').click(function(){
    $('#projectEditForm').submit();
});

function EditStrategy(id, name) {
    $("#edit_strategy_title").text(id);
    $("#edit_strategy_id").val(id); // hidden
    $("#edit_strategy_name").val(name);

    $("#edit-strategy").modal(); // show
}

function EditProject(id, strategy, title, responsible, faculty, startDate, budget) {
    $("#edit_project_toppic").text(id);
    $("#edit_project_id").val(id); // hidden

    $("#edit_project_strategyId option:contains(" + strategy + ")").attr('selected', 'selected');
    $("#edit_project_title").val(title);
    $("#edit_project_responsible option:contains(" + responsible + ")").attr('selected', 'selected');
    $("#edit_project_faculty").val(faculty);

    $("#edit_project_startDate").text(moment(startDate).format("MM/DD/YYYY")); // bug, fix it
    $("#edit_project_budget").val(budget);

    $("#edit-project").modal(); // show
}

