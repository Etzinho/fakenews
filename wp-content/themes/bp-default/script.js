$(function(){
    const $vote_truth = $(".post-content").find(".vote-truth");
    const $vote_false = $(".post-content").find(".vote-false");

    const Ticon = $vote_truth.find("i");
    const Ficon = $vote_false.find("i");

    const Tcounter = $vote_truth.find(".counter");
    const Fcounter = $vote_false.find(".counter");

    let Tcount = parseInt(Tcounter.text());
    let Fcount = parseInt(Fcounter.text());

    let voting = false;
    let creating = false;

    const data = $("#post-data");

    // VOTAR VERDADEIRO
    $vote_truth.click(function(){
        if(voting) return;
        voting = true;
        if(!$(this).hasClass("voted")){

            Ticon.removeClass("fa-chevron-up");
            Ticon.addClass("fa-check");

            Tcount++;
            Tcounter.text(Tcount);

            Ficon.removeClass("fa-times");
            Ficon.addClass("fa-chevron-up");

            if($vote_false.hasClass("voted")){
                $vote_false.removeClass("voted");
                Fcount--;
                Fcounter.text(Fcount);
                API.deleteVote({
                    post: data.data("post"),
                    user: data.data("user"),
                    action: "false"
                });
            }

            $vote_truth.addClass("voted");
            $vote_false.removeClass("voted");
            
            API.addVote({
                post: data.data("post"),
                user: data.data("user"),
                action: "truth"
            }).then(reponse => voting = false);
            

        } else {
            Ticon.removeClass("fa-check");
            Ticon.addClass("fa-chevron-up");

            $vote_truth.removeClass("voted");
            Tcount--;
            Tcounter.text(Tcount);

            API.deleteVote({
                post: data.data("post"),
                user: data.data("user"),
                action: "truth"
            }).then(reponse => voting = false);
        }
    });

    // VOTAR FALSO
    $vote_false.click(function(){
        if(voting) return;
        voting = true;
        if(!$(this).hasClass("voted")){
            Ficon.removeClass("fa-chevron-up");
            Ficon.addClass("fa-times");

            Fcount++;
            Fcounter.text(Fcount);

            Ticon.removeClass("fa-check");
            Ticon.addClass("fa-chevron-up");

            if($vote_truth.hasClass("voted")){
                $vote_truth.removeClass("voted");
                Tcount--;
                Tcounter.text(Tcount);

                API.deleteVote({
                    post: data.data("post"),
                    user: data.data("user"),
                    action: "truth"
                });
            }

            $vote_false.addClass("voted");
            $vote_truth.removeClass("voted");
            API.addVote({
                post: data.data("post"),
                user: data.data("user"),
                action: "false"
            }).then(response => voting = false);
        } else {
            Ficon.removeClass("fa-times");
            Ficon.addClass("fa-chevron-up");
            
            $vote_false.removeClass("voted");
            Fcount--
            Fcounter.text(Fcount);

            API.deleteVote({
                post: data.data("post"),
                user: data.data("user"),
                action: "false"
            }).then(reponse => voting = false);   
        }
    });

    // CRIAR POST
    $("#createPostSave").click(function(){
        if(creating) return;
        creating = true;

        const title = $("#new-post-title").val();
        const content = $("#new-post-content").val();
        const author = $("#new-post-author").val();
        API.createPost({ title, content, author }).then(response => {
            creating = false;
            window.location = response.url;
        });
    });
});