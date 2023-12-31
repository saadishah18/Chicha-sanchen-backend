function socialWindow(url) {
    var left = (screen.width -570) / 2;
    var top = (screen.height -570) / 2;
    var params = "menubar=no,toolbar=no,status=no,width=570,height=570,top=" + top + ",left=" + left;  window.open(url,"NewWindow",params);}

function setShareLinks() {
    var pageUrl = encodeURIComponent(document.URL);
    var tweet = encodeURIComponent($("meta[property='og:description']").attr("content"));

    $(".facebook").on("click", function(e) {
        e.preventDefault();
        pageUrl = $('.facebook').data('url')
        console.log(pageUrl)
        url="https://www.facebook.com/sharer.php?u=" + pageUrl;
        socialWindow(url);
    });

    $(".twitter").on("click", function(e) {
        e.preventDefault()
        tweet = $('.twitter').data('title')
        url = "https://twitter.com/intent/tweet?url=" + pageUrl + "&text=" + tweet;
        socialWindow(url);
    });

    $(".linkedin").on("click", function(e) {
        e.preventDefault();
        url = "https://www.linkedin.com/shareArticle?mini=true&url=" + pageUrl;
        socialWindow(url);
    })
}
