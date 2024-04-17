function searchInDatabase(database, pattern, type) {
    var results = [];

    database.forEach(function(item) {
        if (item[type]) {

            if (item[type].toString().match(new RegExp(pattern, 'i'))) {
                results.push(item);
            }
        }
    });

    return results;
}




