<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CRUD OPERATION - PHP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2>Employee Data</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Age</th>
                    <th>Designation</th>
                    <th>Created Date</th>
                </tr>
            </thead>
            <tbody id="userData">
                <!-- Add more rows here as needed -->

            </tbody>
        </table>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Row</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editUserData">
                        <input type="number" id="updateID" hidden>
                        <div class="form-group">
                            <label for="editName">Name</label>
                            <input type="text" class="form-control" id="editName">
                        </div>
                        <div class="form-group">
                            <label for="editEmail">Email</label>
                            <input type="email" class="form-control" id="editEmail">
                        </div>
                        <div class="form-group">
                            <label for="editAge">Age</label>
                            <input type="number" class="form-control" id="editAge">
                        </div>
                        <div class="form-group">
                            <label for="editEmail">Designation</label>
                            <input type="text" class="form-control" id="editDesignation">
                        </div>
                        <div class="form-group">
                            <label for="editEmail">Created Date</label>
                            <input type="text" class="form-control" id="editCreated" readonly>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveChanges">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script>
    <script>
        function fetchUserData() {
            $.ajax({
                url: 'api/read.php',
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    // Handle the JSON data
                    displayUserData(data.body); // Access the "body" property
                },
                error: function(jqxhr, textStatus, errorThrown) {
                    console.error('Error fetching data:', errorThrown);
                }
            });
        }

        // Function to display the fetched user data on the page
        function displayUserData(userData) {
            const userDataDiv = document.getElementById('userData');
            let html = '';

            // Loop through each JSON object in the array
            userData.forEach(user => {
                html += `
                <tr>
                    <td id="updateID" hidden>${user.id}</td>
                    <td>${user.name}</td>
                    <td>${user.email}</td>
                    <td>${user.age}</td>
                    <td>${user.designation}</td>
                    <td>${user.created}</td>
                    <td>
                        <button class="btn btn-primary btn-sm edit-btn editBtn" data-toggle="modal" data-target="#editModal">Edit</button>
                        <button id="deleteButton" class="btn btn-danger btn-sm delete-btn">Delete</button>
                    </td>
                </tr>
                `;
            });
            userDataDiv.innerHTML = html;
        }



        function deleteData() {
            $.ajax({
                url: 'api/delete.php',
                method: 'DELETE',
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        console.log("Data Deleted:", response.message);
                        // Show a success message to the user, or update the UI as needed
                        alert("Data deleted successfully!");
                    } else {
                        console.error("Data deletion failed:", response.message);
                        // Show an error message to the user or handle the error in UI
                        alert("Data deletion failed. Please try again.");
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error deleting data:", error);
                    // Show an error message to the user or handle the error in UI
                    alert("An error occurred while deleting data.");
                }
            })
        }


        // Fetch the JSON data when the page loads
        fetchUserData();
        $(document).ready(function() {
            $(document).on("click", ".editBtn", function() {
                $tr = $(this).closest('tr');

                var data = $tr.children("td").map(function() {
                    return $(this).text();
                }).get();

                console.log("data:", data);

                $('#updateID').val(data[0])
                $('#editName').val(data[1])
                $('#editEmail').val(data[2])
                $('#editAge').val(data[3])
                $('#editDesignation').val(data[4])
                $('#editCreated').val(data[5])
            });

            $(document).on("click", "#saveChanges", function() {
                const id = $('#updateID').val();
                const name = $('#editName').val();
                const email = $('#editEmail').val();
                const age = $('#editAge').val();
                const designation = $('#editDesignation').val();
                const created = $('#editCreated').val();


                const updatedData = {
                    id: id,
                    name: name,
                    email: email,
                    age: age,
                    designation: designation,
                    created: created,
                };


                Swal.fire({
                    html: `Are you sure you want to update the following details?<br><br>`,
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Yes, update it!",
                    cancelButtonText: "Cancel"
                }).then((result) => {
                    if (result.isConfirmed) {
                        // alert(JSON.stringify(updatedData))
                        // console.log("updated:", updatedData);
                        $.ajax({
                            url: 'api/update.php',
                            method: 'POST',
                            dataType: 'json',
                            data: JSON.stringify(updatedData),

                            success: function(response) {
                                if (response == 'Employee data updated.') {
                                    console.log(response);
                                    location.reload()
                                    // Show a success message to the user or update the UI
                                } else {
                                    console.error("Data update failed:", response.message);
                                    // Show an error message to the user or handle the error in UI
                                }
                            },

                            error: function(xhr, status, error) {
                                console.error("Error updating data:", error);
                                // Show an error message to the user or handle the error in UI
                            }

                        })
                    }
                });

            });
        });
    </script>
</body>

</html>