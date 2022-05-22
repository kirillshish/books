 $("search").on("click", function( event ){
   event.preventDefault();
   console.log( $(this).serialize() );
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: "POST",
        url: '/search',
        data: {id:id},
    });
});
