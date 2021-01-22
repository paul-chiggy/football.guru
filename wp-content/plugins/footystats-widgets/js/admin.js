
jQuery(document).ready(function($) {

  let upcoming_fixture_widget = {};

  // Find Teams w/ AJAX

  upcoming_fixture_widget.loadTeams = function(element){

    let parent = $(element).parents(".fs_form_wrapper");
    let league_id = element.value;
    let edit = $(parent).find("[data-uid=fs_next_fixture_club]");

    $.ajax({
      url: "https://footystats.org/e/team-list?id=" + league_id,
    }).done(function(data) {
      data = jQuery.parseJSON(data);
      $(edit).html(data);
    });

  }

  // Listeners

  $(document).on('change','[data-uid=fs_next_fixture_league]', function(e){
    upcoming_fixture_widget.loadTeams(this);
    let outer = $(this).parents(".fs_form_wrapper");
    let league_name = $(outer).find("[data-uid=fs_league_name]");
    let selected_league = $('option:selected',this).text();
    $(league_name).val(selected_league);
  });

  $(document).on('change','[data-uid=fs_next_fixture_club]', function(e){
    let outer = $(this).parents(".fs_form_wrapper");
    let club_name = $(outer).find("[data-uid=fs_club_name]");
    let selected_club = $('option:selected',this).text();
    $(club_name).val(selected_club);
  });

  $(document).on('change','[data-uid=fs_league_standings]', function(e){
    let outer = $(this).parents(".fs_form_wrapper");
    let league_name = $(outer).find("[data-uid=fs_league_name]");
    let selected_league = $('option:selected',this).text();
    $(league_name).val(selected_league);
  });

}); // doc ready



// function loadTeams(el){

//   let league_id = el.value;
//   let team_selection = $(el).closest('select.fs_next_fixture_club');
//   console.log(team_selection);

//   fetch('https://footystats.org/e/team-list')
//   .then((response) => {
//     return response.json();
//   })
//   .then((data) => {
//     // team_selection.innerHTML = data;
//   });
  
// }


  


