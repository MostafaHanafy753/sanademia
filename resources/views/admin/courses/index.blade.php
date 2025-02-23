@extends('layouts.backend')

@section('content')
    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Manage Courses</h1>
            <!-- Add New Course Button -->
            <button class="btn btn-primary" id="addCourseBtn" title="Add New Course">Add New Course</button>
        </div>
        <!-- Courses Table -->
        <table class="table table-bordered" id="coursesTable">
            <thead>
            <tr>
                <th>Course Title</th>
                <th>Category</th>
                <th>Teacher</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
             </tbody>
        </table>


    </div>
    <div class="paginationContainer" id="paginationContainer">

    </div>
    <!-- ========== Modals ========== -->

    <!-- Edit Course Modal (used for both adding and editing courses) -->
    <div class="modal fade" id="editCourseModal" tabindex="-1" aria-labelledby="editCourseModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="editCourseForm" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editCourseModalLabel">Edit Course</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Hidden field for course id -->
                        <input type="hidden" id="editCourseId" name="course_id"/>

                        <div class="row">


                            <!-- Other course fields -->
                            <div class="mb-3 col-md-6">
                                <label for="courseTitle" class="form-label">Title</label>
                                <input type="text" class="form-control" id="courseTitle" name="title" required/>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="courseCategory" class="form-label">Category</label>
                                <select name="category_id" id="courseCategory" class="form-control" required>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="courseTeacher" class="form-label">Teacher</label>
                                <select name="teacher_id" id="courseTeacher" class="form-control" required>
                                    @foreach($teachers as $teacher)
                                        <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="coursePrice" class="form-label">Price</label>
                                <input type="number" class="form-control" id="coursePrice" name="price" step="0.01"
                                       required/>
                            </div>
                            <!-- Additional fields for discount, task, certificate, etc. -->
                            <div class="mb-3 col-md-6">
                                <label for="afterDiscountPrice" class="form-label">After Discount Price</label>
                                <input type="number" class="form-control" id="afterDiscountPrice"
                                       name="after_discount_price" step="0.01"/>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="discount" class="form-label">Discount</label>
                                <input type="text" class="form-control" id="discount" name="discount"/>
                            </div>

                            <!-- Intro Video Upload -->
                            <div class="mb-3 col-12">
                                <label for="introVideo" class="form-label">Intro Video</label>
                                <input type="file" class="form-control" id="introVideo" name="intro_video"
                                       accept="video/mp4,video/webm,video/ogg"/>
                            </div>
                            <!-- Intro Video Preview -->
                            <div class="mb-3 col-12" id="introVideoPreviewContainer" style="display: none;">
                                <label class="form-label">Intro Video Preview</label>
                                <video id="introVideoPreview" width="100%" controls>
                                    <source src="" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            </div>

                            <!-- Intro Video Thumbnail Upload -->
                            <div class="mb-3 col-12">
                                <label for="introVideoThumbnail" class="form-label">Intro Video Thumbnail</label>
                                <input type="file" class="form-control" id="introVideoThumbnail"
                                       name="intro_video_thumbnail" accept="image/*"/>
                            </div>
                            <!-- Intro Video Thumbnail Preview -->
                            <div class="mb-3 col-12" id="introVideoThumbnailPreviewContainer" style="display: none;">
                                <label class="form-label">Thumbnail Preview</label>
                                <img id="introVideoThumbnailPreview" src="" alt="Thumbnail Preview" class="img-fluid"/>
                            </div>

                            <!-- Other text fields -->
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3"
                                          required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="requirements" class="form-label">Requirements</label>
                                <textarea class="form-control" id="requirements" name="requirements" rows="3"
                                          required></textarea>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="whatWillYouLearn" class="form-label">What Will You Learn</label>
                                <textarea class="form-control" id="whatWillYouLearn" name="what_will_you_learn" rows="3"
                                          required></textarea>
                            </div>
                            <div class="mb-3 col-12">
                                <label for="whoThisCourseIsFor" class="form-label">Who This Course Is For</label>
                                <textarea class="form-control" id="whoThisCourseIsFor" name="who_this_course_is_for"
                                          rows="3" required></textarea>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="language" class="form-label">Language</label>
                                <input type="text" class="form-control" id="language" name="language" required/>
                            </div>


                            <div class="mb-3 col-md-6">
                                <label for="taskIncluded" class="form-label">Task Included</label>
                                <select name="task_included" id="taskIncluded" class="form-control" required>
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="certificate" class="form-label">Certificate</label>
                                <select name="certificate" id="certificate" class="form-control" required>
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Course</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Manage Contents Modal -->
    <div class="modal fade" id="manageContentModal" tabindex="-1" aria-labelledby="manageContentModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="manageContentModalLabel">Manage Course Contents</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Accordion for Contents -->
                    <div class="accordion border shadow-sm" id="courseContentsAccordion">
                        <!-- Content items added via AJAX -->
                    </div>
                    <button class="btn btn-primary btn-sm mt-3" id="addContentBtn" title="Add New Content">Add New Content</button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Content Modal -->
    <div class="modal fade" id="editContentModal" tabindex="-1" aria-labelledby="editContentModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="editContentForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editContentModalLabel">Edit Content</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="editContentId"/>
                        <div class="mb-3">
                            <label for="contentTitle" class="form-label">Content Title</label>
                            <input type="text" class="form-control" id="contentTitle" name="contentTitle" required/>
                        </div>
                        <div class="mb-3">
                            <label for="contentDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="contentDescription" name="contentDescription" rows="3"
                                      required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Content</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Lecture Modal -->
    <div class="modal fade" id="editLectureModal" tabindex="-1" aria-labelledby="editLectureModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="editLectureForm" enctype="multipart/form-data">
                <div class="modal-content ">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editLectureModalLabel">Edit Lecture</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Hidden field for lecture id -->
                        <input type="hidden" id="editLectureId" name="lecture_id"/>


                        <div class="mb-3">
                            <label for="lectureTitle" class="form-label">Lecture Title</label>
                            <input type="text" class="form-control" id="lectureTitle" name="title" required/>
                        </div>

                        <div class="mb-3">
                            <label for="lectureDescription" class="form-label">Lecture Description</label>
                            <textarea class="form-control" id="lectureDescription" name="description"
                                      required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="lectureVideo" class="form-label">Lecture Video</label>
                            <input type="file" class="form-control" id="lectureVideo" name="video"
                                   accept="video/mp4,video/webm,video/ogg"/>
                        </div>

                        <!-- Video Preview -->
                        <div class="mb-3" id="lectureVideoPreviewContainer" style="display: none;">
                            <label class="form-label">Video Preview</label>
                            <video id="lectureVideoPreview" width="100%" controls>
                                <source src="" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>

                        <div class="mb-3">
                            <label for="lectureFile" class="form-label">Additional File</label>
                            <input type="file" class="form-control" id="lectureFile" name="file"
                                   accept=".doc,.docx,.pdf,.xls,.xlsx,.ppt,.pptx,.txt,.zip,.rar,.7z,.mp4,.webm,.ogg,.mp3,.wav,.flac,.avi,.mkv,.mov,.wmv,.flv,.swf,.html,.css,.js,.php,.java,.py,.rb,.c,.go,.swift"/>
                        </div>

                        <!-- File Preview -->
                        <div class="mb-3" id="lectureFilePreviewContainer" style="display: none;">
                            <label class="form-label">File Preview</label>
                            <div id="lectureFilePreview"></div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Lecture</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
@section('js')
    <!-- Bootstrap JS Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- JavaScript: AJAX Operations -->
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            xhrFields: {
                withCredentials: true // Ensure cookies are sent with each request.
            }
        });


        // Global variables for current IDs
        let currentCourseId = null;
        let currentContentId = null;         // For editing content (null means new)
        let currentLectureId = null;         // For editing lecture (null means new)
        let currentContentForLecture = null; // To know which content's lecture is being edited/added

        /***********************************
         * COURSES MANAGEMENT VIA AJAX
         ***********************************/
        // Load all courses from the backend
        function loadCourses() {
            $.ajax({
                url: '/admin/api/courses',
                method: 'GET',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    renderCoursesTable(response);
                },
                error: function (err) {
                    console.error("Error loading courses", err);
                    Swal.fire({
                        icon: 'error',
                        title: '',
                        text: err.message ?? err,
                    })
                }
            });
        }


        // Preview for Intro Video
        $("#introVideo").on("change", function () {
            var file = this.files[0];
            if (file) {
                var fileURL = URL.createObjectURL(file);
                $("#introVideoPreview").find("source").attr("src", fileURL);
                $("#introVideoPreview")[0].load(); // Reload the video element
                $("#introVideoPreviewContainer").show();
            } else {
                $("#introVideoPreviewContainer").hide();
                $("#introVideoPreview").find("source").attr("src", "");
            }
        });


        // Preview for Intro Video Thumbnail
        $("#introVideoThumbnail").on("change", function () {
            var file = this.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $("#introVideoThumbnailPreview").attr("src", e.target.result);
                    $("#introVideoThumbnailPreviewContainer").show();
                };
                reader.readAsDataURL(file);
            } else {
                $("#introVideoThumbnailPreviewContainer").hide();
                $("#introVideoThumbnailPreview").attr("src", "");
            }
        });


        // Renders the courses table along with pagination controls
        function renderCoursesTable(coursesResponse) {
            const tbody = $("#coursesTable tbody");
            tbody.empty();

            // Render each course row
            coursesResponse.data.forEach(course => {
                const tr = $(`
            <tr>
                <td>
                    <img src="${course.intro_video_thumbnail}" alt="${course.title}" class="img-fluid" style="max-width: 100px; border-radius: 5px"/>
                    ${course.title}
                </td>
                <td>${course.category.name}</td>
                <td>${course.teacher.name}</td>
                <td>$${course.price}</td>
                <td>
                    <button class="btn btn-danger btn-sm" onclick="deleteCourse(${course.id})" title="Delete Course">
<i class="fa fa-trash"></i>
</button>
                    <button class="btn btn-primary btn-sm" onclick="openEditCourse(${course.id})" title="Edit Course">
     <i class="fa fa-pen"></i>
</button>
                    <button class="btn btn-secondary btn-sm" onclick="openManageContents(${course.id})" title="Edit Course Contents">
<i class="fa-solid fa-arrows-to-circle"></i>
</button>
                </td>
            </tr>
        `);
                tbody.append(tr);
            });

            // Render pagination controls using the returned links
            renderPagination(coursesResponse.links);
        }

        // Renders pagination controls using the "links" array from the API response
        function renderPagination(links) {
            const paginationContainer = $("#paginationContainer");
            paginationContainer.empty();

            // Create a <ul> element for pagination (Bootstrap style)
            const ul = $('<ul class="pagination justify-content-center"></ul>');

            links.forEach(link => {
                // Determine if the link is active or disabled
                let activeClass = link.active ? "active" : "";
                let disabledClass = link.url === null ? "disabled" : "";

                // Create a list item with an anchor
                const li = $(`
            <li class="page-item ${activeClass} ${disabledClass}">
                <a class="page-link" href="#">${link.label}</a>
            </li>
        `);

                // Only attach click event if the link is not disabled
                if (link.url) {
                    li.on("click", function (e) {
                        e.preventDefault();
                        // Load courses from the provided URL
                        loadCoursesByUrl(link.url);
                    });
                }

                ul.append(li);
            });

            paginationContainer.append(ul);
        }

        // Example function to load courses using a URL (for pagination)
        // This function can simply perform an AJAX GET request to the given URL and then call renderCoursesTable.
        function loadCoursesByUrl(url) {
            $.ajax({
                url: url,
                method: 'GET',
                dataType: 'json',
                success: function (response) {
                    renderCoursesTable(response);
                },
                error: function (err) {
                    console.error("Error loading courses by URL", err);
                    Swal.fire({
                        icon: 'error',
                        title: '',
                        text: err.message ?? err,
                    })
                }
            });
        }


        function openEditCourse(courseId) {
            currentCourseId = courseId;
            $.ajax({
                url: '/admin/api/courses/' + courseId,
                method: 'GET',
                dataType: 'json',
                success: function (course) {
                    // Fill in form fields with course data
                    $("#editCourseId").val(course.id);
                    $("#courseTitle").val(course.title);
                    // Assuming your API returns category_id and teacher_id for selects:
                    $("#courseCategory").val(course.category_id);
                    $("#courseTeacher").val(course.teacher_id);
                    $("#coursePrice").val(course.price);

                    // Fill in additional fields if available
                    $("#afterDiscountPrice").val(course.after_discount_price);
                    $("#discount").val(course.discount);
                    $("#taskIncluded").val(course.task_included ? "1" : "0");
                    $("#certificate").val(course.certificate ? "1" : "0");
                    $("#description").val(course.description);
                    $("#requirements").val(course.requirements);
                    $("#whatWillYouLearn").val(course.what_will_you_learn);
                    $("#whoThisCourseIsFor").val(course.who_this_course_is_for);
                    $("#language").val(course.language);

                    // Set up video preview if an intro video URL is provided
                    if (course.intro_video) {
                        // Create a temporary URL if needed or directly use the returned URL
                        $("#introVideoPreview").find("source").attr("src", course.intro_video);
                        $("#introVideoPreview")[0].load();
                        $("#introVideoPreviewContainer").show();
                    } else {
                        $("#introVideoPreviewContainer").hide();
                        $("#introVideoPreview").find("source").attr("src", "");
                    }

                    // Set up thumbnail preview if an intro video thumbnail URL is provided
                    if (course.intro_video_thumbnail) {
                        $("#introVideoThumbnailPreview").attr("src", course.intro_video_thumbnail);
                        $("#introVideoThumbnailPreviewContainer").show();
                    } else {
                        $("#introVideoThumbnailPreviewContainer").hide();
                        $("#introVideoThumbnailPreview").attr("src", "");
                    }

                    // Open the modal
                    new bootstrap.Modal(document.getElementById("editCourseModal")).show();
                },
                error: function (err) {
                    console.error("Error fetching course", err);
                    Swal.fire({
                        icon: 'error',
                        title: '',
                        text: err.message ?? err,
                    })
                }
            });
        }


        // When "Add New Course" is clicked
        $("#addCourseBtn").on("click", function () {
            currentCourseId = null;
            // Clear hidden ID field
            $("#editCourseId").val("");
            // Clear text fields
            $("#courseTitle").val("");
            $("#coursePrice").val("");
            $("#afterDiscountPrice").val("");
            $("#discount").val("");
            $("#language").val("");

            // Reset select fields (assuming default selection is the first option)
            $("#courseCategory").prop('selectedIndex', 0);
            $("#courseTeacher").prop('selectedIndex', 0);
            $("#taskIncluded").prop('selectedIndex', 0);
            $("#certificate").prop('selectedIndex', 0);

            // Clear textareas
            $("#description").val("");
            $("#requirements").val("");
            $("#whatWillYouLearn").val("");
            $("#whoThisCourseIsFor").val("");

            // Clear file inputs. Note: For security reasons, you cannot pre-populate file inputs,
            // but you can reset them if they have a value from a previous use.
            $("#introVideo").val("");
            $("#introVideoThumbnail").val("");

            // Open the modal
            new bootstrap.Modal(document.getElementById("editCourseModal")).show();
        });


        // Handle course form submission (add or update)
        $("#editCourseForm").on("submit", function (e) {
            e.preventDefault();

            // Create a FormData object from the form
            var form = document.getElementById("editCourseForm");
            var formData = new FormData(form);

            // Optionally, if you have a global variable currentCourseId defined
            // it may be used to decide whether we're creating or updating.
            var url = '';
            var method = '';
            if (currentCourseId) {
                // Update existing course
                url = '/admin/api/courses/' + currentCourseId;
                method = 'POST'; // Use POST with method override for PUT/PATCH
                formData.append('_method', 'PUT'); // Laravel supports method override via _method field
            } else {
                // Create new course
                url = '/admin/api/courses';
                method = 'POST';
            }

            $.ajax({
                url: url,
                method: method,
                data: formData,
                processData: false,  // Important: do not process the data
                contentType: false,  // Important: let FormData set the content type
                headers: {
                    // Include CSRF token if needed (typically not needed when using cookies in a same-domain app)
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    // Call your function to reload courses (adjust if needed)
                    loadCourses();
                    // Hide the modal
                    bootstrap.Modal.getInstance(document.getElementById("editCourseModal")).hide();

                    //show Swal
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                    })
                },
                error: function (err) {
                    console.error("Error saving course", err);
                    if (err.message) {
                        //show Swal
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: err.message,
                        })
                        console.log('has message', message)
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: err,
                        })
                        console.log('no message', err)
                    }

                }
            });
        });


        // Delete course via AJAX
        function deleteCourse(courseId) {
            if (confirm("Are you sure you want to delete this course?")) {
                $.ajax({
                    url: '/admin/api/courses/' + courseId,
                    method: 'DELETE',
                    success: function () {
                        loadCourses();
                    },
                    error: function (err) {
                        console.error("Error deleting course", err);
                        Swal.fire({
                            icon: 'error',
                            title: '',
                            text: err.message ?? err,
                        })
                    }
                });
            }
        }

        /***********************************
         * CONTENTS MANAGEMENT VIA AJAX
         ***********************************/
        // Open Manage Contents modal for a course
        function openManageContents(courseId) {
            currentCourseId = courseId;
            loadContents();
            new bootstrap.Modal(document.getElementById("manageContentModal")).show();
        }

        // Load contents for a course
        function loadContents() {
            $.ajax({
                url: '/admin/api/courses/' + currentCourseId + '/contents',
                method: 'GET',
                dataType: 'json',
                success: function (contents) {
                    renderContentsAccordion(contents);
                },
                error: function (err) {
                    console.error("Error loading contents", err);
                    Swal.fire({
                        icon: 'error',
                        title: '',
                        text: err.message ?? err,
                    })
                }
            });
        }

        // Render accordion for contents
        // Render accordion for contents
        function renderContentsAccordion(contents) {
            const accordion = $("#courseContentsAccordion");
            accordion.empty();
            if (contents.length === 0) {
                accordion.html("<p>No contents available.</p>");
            } else {
                contents.forEach((content, index) => {
                    const item = $(`
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingContent${content.id}">
                                <button class="accordion-button d-flex justify-content-between align-items-center text-white bg-primary ${index !== 0 ? "collapsed" : ""}"
                                        type="button" data-bs-toggle="collapse" data-bs-target="#collapseContent${content.id}"
                                        aria-expanded="${index === 0 ? "true" : "false"}" aria-controls="collapseContent${content.id}">
                                    <span>${content.title}</span>
                                    <span>
                                        <button class="btn btn-primary btn-sm mx-1" onclick="openEditContent(${content.id}); event.stopPropagation();" title="Edit Content"><i class="fa fa-pen"></i></button>
                                        <button class="btn btn-danger btn-sm" onclick="deleteContent(${content.id}); event.stopPropagation();" title="Delete Content"><i class="fa fa-trash"></i></button>
                                    </span>
                                </button>
                            </h2>
                            <div id="collapseContent${content.id}" class="accordion-collapse collapse ${index === 0 ? "show" : ""}"
                                 aria-labelledby="headingContent${content.id}" data-bs-parent="#courseContentsAccordion">
                                <div class="accordion-body">
                                    <p>${content.description}</p>
                                    <hr>
                                        <h6>Lectures</h6>
                                        <ul class="list-group" id="lecturesList${content.id}"></ul>
                                        <button class="btn btn-primary btn-sm mt-2" onclick="addLecture(${content.id})">Add Lecture</button>
                                </div>
                            </div>
                        </div>`
                    );
                    accordion.append(item);
                    // After appending, load lectures for this content
                    loadLectures(content.id);
                });
            }
        }



        // Delete content via AJAX
        function deleteContent(contentId) {
            if (confirm("Are you sure you want to delete this content?")) {
                $.ajax({
                    url: '/admin/contents/' + contentId,
                    method: 'DELETE',
                    success: function () {
                        loadContents();
                    },
                    error: function (err) {
                        console.error("Error deleting content", err);
                        Swal.fire({
                            icon: 'error',
                            title: '',
                            text: err.message ?? err,
                        })
                    }
                });
            }
        }

        // Open edit content modal (for editing)
        function openEditContent(contentId) {
            currentContentId = contentId;
            $.ajax({
                url: '/admin/contents/' + contentId,
                method: 'GET',
                dataType: 'json',
                success: function (content) {
                    $("#editContentId").val(content.id);
                    $("#contentTitle").val(content.title);
                    $("#contentDescription").val(content.description);
                    new bootstrap.Modal(document.getElementById("editContentModal")).show();
                },
                error: function (err) {
                    console.error("Error fetching content", err);
                    Swal.fire({
                        icon: 'error',
                        title: '',
                        text: err.message ?? err,
                    })
                }
            });
        }

        // When "Add New Content" is clicked
        $("#addContentBtn").on("click", function () {
            currentContentId = null;
            $("#editContentId").val("");
            $("#contentTitle").val("");
            $("#contentDescription").val("");
            new bootstrap.Modal(document.getElementById("editContentModal")).show();
        });

        // Handle content form submission (add or update)
        $("#editContentForm").on("submit", function (e) {
            e.preventDefault();
            const contentData = {
                title: $("#contentTitle").val(),
                description: $("#contentDescription").val()
            };
            if (currentContentId) {
                // Update content
                $.ajax({
                    url: '/admin/contents/' + currentContentId,
                    method: 'PUT',
                    contentType: "application/json",
                    data: JSON.stringify(contentData),
                    success: function () {
                        loadContents();
                        bootstrap.Modal.getInstance(document.getElementById("editContentModal")).hide();
                    },
                    error: function (err) {
                        console.error("Error updating content", err);
                        Swal.fire({
                            icon: 'error',
                            title: '',
                            text: err.message ?? err,
                        })
                    }
                });
            } else {
                // Add new content (POST to the course's contents endpoint)
                $.ajax({
                    url: '/admin/api/courses/' + currentCourseId + '/contents',
                    method: 'POST',
                    contentType: "application/json",
                    data: JSON.stringify(contentData),
                    success: function () {
                        loadContents();
                        bootstrap.Modal.getInstance(document.getElementById("editContentModal")).hide();
                    },
                    error: function (err) {
                        console.error("Error creating content", err);
                        Swal.fire({
                            icon: 'error',
                            title: '',
                            text: err.message ?? err,
                        })
                    }
                });
            }
        });

        /***********************************
         * LECTURES MANAGEMENT VIA AJAX
         ***********************************/
        // Load lectures for a given content
        function loadLectures(contentId) {
            $.ajax({
                url: '/admin/contents/' + contentId + '/lectures',
                method: 'GET',
                dataType: 'json',
                success: function (lectures) {
                    renderLecturesList(contentId, lectures);
                },
                error: function (err) {
                    console.error("Error loading lectures", err);
                    Swal.fire({
                        icon: 'error',
                        title: '',
                        text: err.message ?? err,
                    })
                }
            });
        }

        // Video Preview
        $("#lectureVideo").on("change", function () {
            var file = this.files[0];
            if (file) {
                var fileURL = URL.createObjectURL(file);
                $("#lectureVideoPreview").find("source").attr("src", fileURL);
                $("#lectureVideoPreview")[0].load(); // Reload the video element
                $("#lectureVideoPreviewContainer").show();
            } else {
                $("#lectureVideoPreviewContainer").hide();
                $("#lectureVideoPreview").find("source").attr("src", "");
            }
        });

        // File Preview
        $("#lectureFile").on("change", function () {
            var file = this.files[0];
            if (file) {
                // If the file is an image, display the image preview
                if (file.type.startsWith("image/")) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $("#lectureFilePreview").html('<img src="' + e.target.result + '" alt="File Preview" class="img-fluid" />');
                        $("#lectureFilePreviewContainer").show();
                    };
                    reader.readAsDataURL(file);
                } else {
                    // For other file types, display the file name
                    $("#lectureFilePreview").html('<p>' + file.name + '</p>');
                    $("#lectureFilePreviewContainer").show();
                }
            } else {
                $("#lectureFilePreviewContainer").hide();
                $("#lectureFilePreview").html('');
            }
        });


        // Render lectures list for a given content
        function renderLecturesList(contentId, lectures) {
            const container = $("#lecturesList" + contentId);
            container.empty();

            if (lectures.length === 0) {
                container.html("<p>No lectures available.</p>");
                return;
            }

            const table = $(`
        <table class="table table-bordered table-striped">
            <thead class="table-primary">
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Duration (min)</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="lectureTableBody${contentId}">
            </tbody>
        </table>
    `);

            container.append(table);
            const tbody = $("#lectureTableBody" + contentId);

            lectures.forEach((lecture, index) => {
                const row = $(`
            <tr>
                <td>${index + 1}</td>
                <td>${lecture.title}</td>
                <td>${lecture.minutes}</td>
                <td>
                    <button class="btn btn-primary btn-sm" onclick="openEditLecture(${contentId}, ${lecture.id})" title="Edit Lecture">
                        <i class="fa fa-pen"></i>
                    </button>
                    <button class="btn btn-danger btn-sm" onclick="deleteLecture(${contentId}, ${lecture.id})" title="Delete Lecture">
                        <i class="fa fa-trash"></i>
                    </button>
                </td>
            </tr>
        `);
                tbody.append(row);
            });
        }


        // Open edit lecture modal (for editing)
        function openEditLecture(contentId, lectureId) {
            currentContentForLecture = contentId;
            currentLectureId = lectureId;
            $.ajax({
                url: '/admin/api/lectures/' + lectureId,
                method: 'GET',
                dataType: 'json',
                success: function (lecture) {
                    // Populate text fields
                    $("#editLectureId").val(lecture.id);
                    $("#lectureTitle").val(lecture.title);
                    $("#lectureDescription").val(lecture.description);

                    // Clear file inputs (they cannot be pre-populated)
                    $("#lectureVideo").val("");
                    $("#lectureFile").val("");

                    // Set up video preview if a video URL is returned
                    if (lecture.video_url) {
                        $("#lectureVideoPreview").find("source").attr("src", lecture.video_url);
                        $("#lectureVideoPreview")[0].load();
                        $("#lectureVideoPreviewContainer").show();
                    } else {
                        $("#lectureVideoPreviewContainer").hide();
                        $("#lectureVideoPreview").find("source").attr("src", "");
                    }

                    // Set up file preview if a file URL is returned
                    if (lecture.file) {
                        previewLectureFile(lecture.file);
                    } else {
                        $("#lectureFilePreviewContainer").hide();
                        $("#lectureFilePreview").html('');
                    }

                    // Open the modal
                    new bootstrap.Modal(document.getElementById("editLectureModal")).show();
                },
                error: function (err) {
                    console.error("Error fetching lecture", err);
                    Swal.fire({
                        icon: 'error',
                        title: '',
                        text: err.message ?? err,
                    })
                }
            });
        }

        function previewLectureFile(fileUrl) {
            // Create an anchor tag with the file URL
            var linkHtml = '<a href="' + fileUrl + '" target="_blank" class="btn btn-link">View File</a>';
            // Display the link in the preview container
            $("#lectureFilePreview").html(linkHtml);
            $("#lectureFilePreviewContainer").show();
        }


        // When "Add Lecture" is clicked (clear form and open modal)
        function addLecture(contentId) {
            currentContentForLecture = contentId;
            currentLectureId = null;
            $("#editLectureId").val("");
            $("#lectureTitle").val("");
            $("#lectureDescription").val("");
            $("#lectureVideo").val("");
            $("#lectureVideoPreviewContainer").hide();
            $("#lectureFile").val("");
            $("#lectureFilePreviewContainer").hide();
            new bootstrap.Modal(document.getElementById("editLectureModal")).show();
        }

        // Handle lecture form submission (add or update)

        $("#editLectureForm").on("submit", function (e) {
            e.preventDefault();

            var form = document.getElementById("editLectureForm");
            var formData = new FormData(form);

            // Determine URL and HTTP method based on whether we're editing or adding a lecture.
            var url = '';
            var method = '';
            if (currentLectureId) {
                // Update existing lecture (using method override for PUT)
                url = '/admin/api/lectures/' + currentLectureId;
                method = 'POST';
                formData.append('_method', 'PUT');
            } else {
                // Create new lecture (assuming you have currentContentForLecture set)
                url = '/admin/api/contents/' + currentContentForLecture + '/lectures';
                method = 'POST';
            }

            $.ajax({
                url: url,
                method: method,
                data: formData,
                processData: false,  // Do not process FormData
                contentType: false,  // Let FormData set content type
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    // Refresh lectures list (assuming you have a function for that)
                    loadLectures(currentContentForLecture);
                    // Hide the modal
                    bootstrap.Modal.getInstance(document.getElementById("editLectureModal")).hide();
                },
                error: function (err) {
                    console.error("Error saving lecture", err);
                    Swal.fire({
                        icon: 'error',
                        title: '',
                        text: err.message ?? err,
                    })
                }
            });
        });

        // Delete lecture via AJAX
        function deleteLecture(contentId, lectureId) {
            if (confirm("Are you sure you want to delete this lecture?")) {
                $.ajax({
                    url: '/admin/api/lectures/' + lectureId,
                    method: 'DELETE',
                    success: function () {
                        loadLectures(contentId);
                    },
                    error: function (err) {
                        console.error("Error deleting lecture", err);
                        Swal.fire({
                            icon: 'error',
                            title: '',
                            text: err.message ?? err,
                        })
                    }
                });
            }
        }

        // Initial load of courses when the page loads
        $(document).ready(function () {
            loadCourses();
        });
    </script>
@endsection
