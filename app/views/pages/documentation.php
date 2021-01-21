<?php
require APPROOT . '/views/includes/header.php';
require APPROOT . '/views/includes/navigation.php';
?>

    <main>
        <div class="row">
            <div class="container">
                <div class="col s12 m10">
                    <center><h1>Api list</h1></center>
                    <div class="card-panel ">
                        <h4>http://localhost/BenUniWork/api/login</h4>
                        <p><strong>Type: </strong>Post</p>
                        <p><strong>Request Body: </strong></p>
                            <p style="margin-left: 50px">username (string) <span style="color: red">*required</span></p>
                            <p style="margin-left: 50px">password (password) <span style="color: red">*required</span></p>
                        <p><strong>Response: </strong></p>
                            <p style="margin-left: 50px">message (string)</p>
                            <p style="margin-left: 50px">access_token (jwt token)</p>
                        <p><strong>Sample: </strong></p>
                        <div style="margin-left: 50px">
                            <img src="../public/1.png" style="width: 100%" />
                        </div>
                    </div>

                    <div class="card-panel ">
                        <h4>http://localhost/BenUniWork/api/update</h4>
                        <p><strong>Type: </strong>Post</p>
                        <p style="color: red">Role: Admin </p>
                        <p style="color: red">auth: required </p>
                        <p><strong>Request Body: </strong></p>
                        <p style="margin-left: 50px">sessionId (integer) <span style="color: red">*required</span></p>
                        <p style="margin-left: 50px">name (string) <span style="color: red">*required</span></p>
                        <p><strong>Response: </strong></p>
                        <p style="margin-left: 50px">message (string)</p>
                        <p><strong>Sample: </strong></p>
                        <div style="margin-left: 50px">
                            <img src="../public/2.png" style="width: 100%" />
                        </div>
                    </div>

                    <div class="card-panel ">
                        <h4>http://localhost/BenUniWork/api/delete-session</h4>
                        <p><strong>Type: </strong>Post</p>
                        <p style="color: red">Role: Admin </p>
                        <p style="color: red">auth: required </p>
                        <p><strong>Request Body: </strong></p>
                        <p style="margin-left: 50px">sessionId (integer) <span style="color: red">*required</span></p>
                        <p><strong>Response: </strong></p>
                        <p style="margin-left: 50px">message (string)</p>
                        <p><strong>Sample: </strong></p>
                        <div style="margin-left: 50px">
                            <img src="../public/3.png" style="width: 100%" />
                        </div>
                    </div>

                    <div class="card-panel ">
                        <h4>http://localhost/BenUniWork/api/room-sessions</h4>
                        <p><strong>Type: </strong>Post</p>
                        <p style="color: red">auth: required </p>
                        <p><strong>Request Body: </strong></p>
                        <p style="margin-left: 50px">roomId (integer) <span style="color: red">*required</span></p>
                        <p><strong>Response: </strong></p>
                        <p style="margin-left: 50px">message (string)</p>
                        <p style="margin-left: 50px">roomSession (object)</p>
                        <p><strong>Sample: </strong></p>
                        <div style="margin-left: 50px">
                            <img src="../public/4.png" style="width: 100%" />
                        </div>
                    </div>

                    <div class="card-panel ">
                        <h4>http://localhost/BenUniWork/api/total-count</h4>
                        <p><strong>Type: </strong>Get</p>
                        <p style="color: red">auth: required </p>
                        <p><strong>Request Body: </strong></p>
                        <p style="margin-left: 50px">No parameters</p>
                        <p><strong>Response: </strong></p>
                        <p style="margin-left: 50px">message (string)</p>
                        <p style="margin-left: 50px">count (number)</p>
                        <p><strong>Sample: </strong></p>
                        <div style="margin-left: 50px">
                            <img src="../public/5.png" style="width: 100%" />
                        </div>
                    </div>

                    <div class="card-panel ">
                        <h4>http://localhost/BenUniWork/api/show-session</h4>
                        <p><strong>Type: </strong>Get</p>
                        <p style="color: red">auth: required </p>
                        <p><strong>Request Body: </strong></p>
                        <p style="margin-left: 50px">sessionId (integer) <span style="color: red">*required</span></p>
                        <p><strong>Response: </strong></p>
                        <p style="margin-left: 50px">message (string)</p>
                        <p style="margin-left: 50px">selectedSession (object)</p>
                        <p><strong>Sample: </strong></p>
                        <div style="margin-left: 50px">
                            <img src="../public/6.png" style="width: 100%"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>


<?php
require APPROOT . '/views/includes/footer.php';
?>