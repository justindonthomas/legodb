$("#favoriteInput").submit(function(event) {
    event.preventDefault();
    var partNum = $("#partnum").val();
    var comment = $("#comment").val();
    $.post('pageScripts/inputFavorites.php',
        {
            partnum : partNum,
            comment : comment
        }, function(data) {
            alert(data);
        });
});

$("#searchForm").submit(function(event) {
    event.preventDefault();
    var searchFor = $("#searchFor").val();
    var searchBy = $("#searchBy").val();
    var searchTerms = $("#searchTerms").val();
    var colorTerms = $("#colorTerm").val();
    //console.log(" " + searchFor + " " + searchBy + " " + searchTerms);
    $.post('pageScripts/performSearch.php',
        {
            searchfor : searchFor,
            searchby : searchBy,
            searchterms: searchTerms,
            colorTerms : colorTerms
        }, function(data) {
            $("#results").html(data);
        } );
});

function createSearchByDropdown(searchFor, searchBy, colorTerm) {
    var userSearchTerms = ['user name', 'email', 'all'];
    var standardSearchTerms = ['part id', 'description', 'year', 'theme'];
    searchBy.options.length = 0;
    switch(searchFor.value) {
        case "user":
            //create user search options
            colorTerm.style.display = "none";
            for(var i = 0; i < userSearchTerms.length; ++i) {
                searchBy.options.add(createListOption(userSearchTerms[i]));
            }
            break;
        case "minifig inventory":
        case "set inventory":
            colorTerm.style.display = "none";
            searchBy.options.add(createListOption('part id'));
            break;
        case "my favorites":
        case "":
            colorTerm.style.display = "none";
            searchBy.options.length=0;
            break;
        case "image":
            colorTerm.style.display = "block";
            break;
        default:
            //create general search options
            colorTerm.style.display = "none";
            for(var i = 0; i < standardSearchTerms.length; ++i) {
                searchBy.options.add(createListOption(standardSearchTerms[i]));
            }
    }
}

function createListOption(term) {
    var opt = document.createElement('option');
    opt.text = term;
    opt.value = term;
    return opt;
}
