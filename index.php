<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Bookmark Manage</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">📚 Simple Bookmark Manager</h1>

        <!-- Add Bookmark Form -->
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Add New Bookmark</h5>
                <form action="server.php" method="POST" id="bookmarkForm">
                    <input type="hidden" name="action" value="add">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" 
                        name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="url" class="form-label">URL</label>
                        <input type="url" class="form-control" id="url" 
                        name="url" required>
                    </div>
                    <button type="submit" class="btn btn-primary ">Add Bookmark</button>
                </form>
            </div>
        </div>

        <!-- Bookmarks list -->
         <div id="bookmarksList">
            <h3 class="mb-3">My Bookmarks</h3>
            <div class="row" id="bookmarksContainer">
                <!-- Bookmarks will be loaded hear via AJAX -->
            </div>
         </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        //locad bookmarks when page loaded
        document.addEventListener('DOMContentLoaded', function(){
            loadBookmarks();
        });

        //function to load bookmarks form server
        function loadBookmarks(){
            fetch('server.php?action=get')
            .then(response => response.json())
            .then(data => {
                const container = document.getElementById('bookmarksContainer');
                container.innerHTML = '';

                if(data.length === 0){
                    container.innerHTML = 
                    '<p class="text-muted">No bookmarks yet. Add your bookmarks!!</p>';
                }

                data.forEach(bookmark => {
                    const col = document.createElement('div');
                    col.className = 'col-md-4 mb-4';
                    col.innerHTML = `
                        <div class="card bookmark-card">
                            <div class="card-body">
                                <h5 class="card-title">${bookmark.title}</h5>
                                <a href="${bookmark.url}" target="_blank" class="card-link">Visit Site</a>

                                <button class="btn btn-sm btn-danger float-end">Delete</button>
                            </div>
                        </div>
                    `;
                    container.appendChild(col);
                });
            });
        }
    </script>
</body>

</html>