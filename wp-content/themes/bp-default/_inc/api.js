const API = {
    baseurl: `${window.location.origin}/fakenews/wp-json/fakenews/v1/`,
    createPost: function(data){
        return jQuery.ajax({
            url: this.baseurl + "post",
            method: "POST",
            data
        });
    },
    addVote: function(data){
        return jQuery.ajax({
            url: this.baseurl + "vote",
            method: "POST",
            data
        });
    },
    deleteVote: function(data){
        return jQuery.ajax({
            url: this.baseurl + "vote",
            method: "DELETE",
            data
        });
    }
}

const $ = jQuery;