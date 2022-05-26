window.onload = function(){
    let searchInput = document.getElementById("search-input");
    let inputs = document.getElementsByClassName("checkbox-input");
    let submitInput = document.getElementById("submit-inpit");

    searchInput.addEventListener('keyup',sendRequest);
    submitInput.addEventListener('click',sendRequest);
    for(let i = 0; i < inputs.length; i++){
        inputs[i].addEventListener('change',sendRequest);
    }
}

async function sendRequest(event) {
    event.preventDefault();

    let form = document.getElementById("book-search-form");
    let data = new FormData(form);
    
    const object = Object.fromEntries(data.entries());
    object.authors = data.getAll("authors");
    object.genres = data.getAll("genres");
    const jsonContent = JSON.stringify(object);


    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: "POST",
        url: "/search",
        data: {jsonContent:jsonContent},
        success: function(data){
            let dataParse = JSON.parse(data);

            let el = document.getElementById("books-block");
            el.innerHTML = '';

            for(let i = 0; i < Object.keys(dataParse).length; i += 3){
                el.innerHTML += '<div class="book">' +
                    '    <img src="' + dataParse[i]["image_path"] + '" alt="image">' +
                    '    <p>' + dataParse[i]["title"] + '</p>' +
                    '    <p>' + dataParse[i]["description"] + '</p>' +
                    '    <p>' + dataParse[i]["genres"][0]['name'] + '</p>' +
                    '    <p>' + dataParse[i]["authors"][0]['first_name'] + dataParse[i]["authors"][0]['middle_name'] + dataParse[i]["authors"][0]['last_name'] + '</p>' +
                    '</div>'
            }
        }
    });
}
