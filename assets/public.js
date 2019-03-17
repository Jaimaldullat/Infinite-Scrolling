// Get elements in global scope to use anywhere
var container = document.getElementById('blog-posts');
var spinner = document.getElementById('spinner');
var is_request_in_progress = false;

// Append result to the main section ( Container )
const appendToSection = (container, new_html) => {

    // Put the new HTML into a temp div
    // This causes browser to parse it as elements.
    var temp_div = document.createElement('div');
    temp_div.innerHTML = new_html;

    // Then we can find and work with those elements.
    // Use firstElementChild b/c of how DOM treats whitespace.
    var class_name = temp_div.firstElementChild.className;
    var items = temp_div.getElementsByClassName(class_name);

    var length = items.length;
    for (var i = 0; i < length; i++) {
        container.appendChild(items[0]);
    }
};

const showSpinner = () => {
    spinner.style.display = 'flex';
}


const hideSpinner = () => {
    spinner.style.display = 'none';
}

// Main function to call Ajax
const loadMore = () => {
    if(is_request_in_progress) {
        return;
    }
    is_request_in_progress = true;

    showSpinner();

    var page = parseInt(container.getAttribute('data-page'));
    var next_page = page + 1;
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'blog_posts.php?page=' + page, true);
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.onreadystatechange = function(){
        if(xhr.readyState < 4){
            console.log("Waiting...");
        }else if(xhr.readyState === 4 && xhr.status === 200) {
            var result = xhr.responseText;
            if (result.trim()) {
                // Append result to the blog-posts main section
                appendToSection(container, result);

                is_request_in_progress = false;
                container.setAttribute('data-page', next_page);

            }
            hideSpinner();
        }
    };
    xhr.send();
};

const scrollReaction = () => {
    var content_height = container.offsetHeight;
    var current_y = window.innerHeight + window.pageYOffset;
    if(current_y > content_height){
        loadMore();
    }
}

window.onscroll = () => {
    scrollReaction();
}

// Load even the first page with Ajax
loadMore();