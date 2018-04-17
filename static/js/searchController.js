$("#searchForm").submit(function(event) {
    event.preventDefault();
    var searchFor = $("#searchFor").val();
    var searchBy = $("#searchBy").val();
    var searchTerms = $("#searchTerms").val();
    //console.log(" " + searchFor + " " + searchBy + " " + searchTerms);
    $.post('pageScripts/performSearch.php',
        {
            searchfor : searchFor,
            searchby : searchBy,
            searchterms: searchTerms
        }, function(data) {
            console.log(data.toString());
        } );
});

/*function searchResponse(data) {
    console.log(data);
}*/

function createSearchByDropdown(searchFor, searchBy) {
    var userSearchTerms = ['user name', 'email'];
    var standardSearchTerms = ['part id', 'description contains'];
    searchBy.options.length = 0;
    switch(searchFor.value) {
        case "user":
            //create user search options
            for(var i = 0; i < userSearchTerms.length; ++i) {
                searchBy.options.add(createListOption(userSearchTerms[i]));
            }
            break;
        case "":
            searchBy.options.length=0;
            break;
        default:
            //create general search options
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
