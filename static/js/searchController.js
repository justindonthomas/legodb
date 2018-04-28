/**
 * Upon entering a favorite set, post to inputFavorites.php
 */
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

/**
 * Search database form submit.
 */
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

/**
 * Generate the dropdown menu for the 'search by' options based on the 'search for' provided
 * by the user.
 * @param searchFor First dropdown menu object.
 * @param searchBy Second dropdown menu object.
 * @param colorTerm Second input field for use in part image searches.
 */
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

/**
 * Helper method to generate options for dropdown lists.
 * @param term text and value to provide.
 * @returns {HTMLOptionElement}
 */
function createListOption(term) {
    var opt = document.createElement('option');
    opt.text = term;
    opt.value = term;
    return opt;
}
