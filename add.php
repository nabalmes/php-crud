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
    <div id="add-modal" class="container my-6">
        <form method="post">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp">
                <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
            </div>
            <div class="mb-3">
                <label for="age" class="form-label">Age</label>
                <input type="number" class="form-control" name="age" id="age">
            </div>
            <div class="mb-3">
                <label for="designation" class="form-label">Designation</label>
                <input type="text" class="form-control" name="designation" id="designation">
            </div>
            <button id="btnSubmitAE" type="button" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script>
<script>
    $(document).ready(function() {
        $('#btnSubmitAE').click(function() {
            var name = $('#name').val();
            var email = $.trim($('#email').val());
            var age = $.trim($('#age').val());
            var designation = $.trim($('#designation').val());

            var requestData = JSON.stringify({
                'name': name,
                'email': email,
                'age': age,
                'designation': designation,
            });
            console.log('Data being sent:', requestData);
            // console.log(name, email, age, designation);
            if (name == "" || email == "" || age == "" || designation == "") {
                Swal.fire({
                    text: "Fill out required fields.",
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "OK",
                    customClass: {
                        confirmButton: "btn font-weight-bold btn-light",
                    },
                });
                return;
            } else {
                $.ajax({
                    url: "api/create.php",
                    method: "POST",
                    data: JSON.stringify({
                        'name': name,
                        'email': email,
                        'age': age,
                        'designation': designation,

                    }),
                    success: function() {
                        Swal.fire({
                                text: "User added successfully.",
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "OK",
                                customClass: {
                                    confirmButton: "btn font-weight-bold btn-light",
                                },
                            })
                            .then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            });

                    }
                });
            }
        });

    });
</script>

</html>