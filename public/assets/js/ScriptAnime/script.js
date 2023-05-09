var menuIcon = document.querySelector(".menu_icon")
var sidebar = document.querySelector(".sidebar")
var content = document.querySelector(".content")

menuIcon.onclick =function(){
    sidebar.classList.toggle("small-sidebar")
    content.classList.toggle("large-content")
}


document.querySelector(".logo").addEventListener("click", () => {
    window.location.href = "index.html";
});


// -----------------------------------

let searchInput = document.getElementById("search_input");

searchInput.addEventListener("keydown", async function (event) {
    if (event.code === "Enter") {
       
            try {
                let inp= searchInput.value;
        
                let res = await fetch(`https://youtube.googleapis.com/youtube/v3/search?part=snippet&q=${inp}&key=AIzaSyCWmsjslHkf5HrCvKjkSL-G89v3inCk-18&maxResults=40&order=viewCount&safeSearch=strict`);
                let data = await res.json();
                console.log(data.items);
                appendvideos(data.items);
        
            } catch (error) {
                console.log(error);
            
                
        }
        document.querySelector(".banner").style.display = "none";
        searchInput.value = '';
        
    }
 });

// -------------------------------
