@extends('layouts.backend')

@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-1">
                        Course Registration Requests
                    </h1>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="{{ url('admin/dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Course Registration Requests
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- END Hero -->

    <!-- Page Content -->
    <div class="content">
        <!-- Your Block -->
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Course Registration Requests Table </h3>
            </div>
            <div class="block-content block-content-full overflow-x-auto">
                <!-- DataTables init on table by adding .js-dataTable-full class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _js/pages/be_tables_datatables.js -->
                <table class="table table-bordered table-striped table-vcenter js-dataTable-full">
                    <thead>
                    <tr>
                        <th class="text-center" style="width: 80px;">ID</th>
                        <th>Name</th>
                        <th>Phone Number</th>
                        <th>Mode</th>
                        <th class="text-center">Course Name</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if (!empty($requests))
                        @foreach ($requests as $request)
                            <tr>
                                <td class="text-center fs-sm">{{ $request->id }}</td>
                                <td class="fw-semibold fs-sm">{{ $request->full_name }}</td>
                                <td class="fw-semibold fs-sm">{{ $request->phone_no }}</td>
                                <td class="fs-sm">{{ $request->course_mode }}</td>
                                <td class="text-center">
                                    @if($request->courses->isNotEmpty())
                                        {{ $request->courses->pluck('title')->join(', ') }}
                                    @else
                                        -
                                    @endif
                                    {{-- <button
                                        type="button"
                                        class="btn btn-sm btn-primary view-courses"
                                        data-courses="{{ json_encode($request->courses->toArray()) }}"
                                        data-bs-toggle="modal"
                                        data-bs-target="#coursesModal">
                                        Courses
                                    </button> --}}
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END Your Block -->
    </div>
    <!-- END Page Content -->

    <!-- Courses Modal -->
    <div class="modal fade" id="coursesModal" tabindex="-1" aria-labelledby="coursesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="coursesModalLabel">Courses</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row" id="courseList">
                        <!-- Course cards will be dynamically loaded here -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function () {
            $('.view-courses').click(function () {
                const courses = $(this).data('courses'); // Get course IDs from data attribute
                const courseList = $('#courseList'); // Reference to the modal content container
                courseList.empty(); // Clear previous content

                if (courses.length === 0) {
                    courseList.append('<p class="text-danger">No courses found.</p>');
                    return;
                }

                courses.forEach(course => {
                    // Strip HTML tags from instructor field
                    const instructor = course.instructor
                        ? course.instructor.replace(/<\/?[^>]+(>|$)/g, '') // Regex to strip HTML tags
                        : 'غير متوفر';
                    console.log(course);
                    const cardHtml = `
                        <div class="col-md-4">
                            <div class="card course-card mb-5" data-id="${course.id}">
                                <img src="${course.banner}" class="card-img-top img-fluid" style="width: 100%" alt="${course.title}">
                                <div class="card-body">
                                    <h5 class="card-title">${course.title}</h5>

                                    <p class="card-text">Price: $${course.price}</p>
                                </div>
                            </div>
                        </div>`;
                    courseList.append(cardHtml);
                })

                // AJAX request to fetch courses
                {{--$.ajax({--}}
                {{--    url: "{{ route('admin.load-courses') }}", // API route--}}
                {{--    method: "GET",--}}
                {{--    data: { courses: courses }, // Send the courses (comma-separated IDs)--}}
                {{--    success: function (response) {--}}
                {{--        // Dynamically generate course cards--}}
                {{--        response.forEach(course => {--}}
                {{--            // Strip HTML tags from instructor field--}}
                {{--            const instructor = course.instructor--}}
                {{--                ? course.instructor.replace(/<\/?[^>]+(>|$)/g, '') // Regex to strip HTML tags--}}
                {{--                : 'غير متوفر';--}}

                {{--            const cardHtml = `--}}
                {{--        <div class="col-md-4">--}}
                {{--            <div class="card course-card mb-5" data-id="${course.id}">--}}
                {{--                <img src="${course.banner}" class="card-img-top img-fluid" style="width: 100%" alt="${course.title}">--}}
                {{--                <div class="card-body">--}}
                {{--                    <h5 class="card-title">${course.title}</h5>--}}

                {{--                    <p class="card-text">Price: $${course.price}</p>--}}
                {{--                </div>--}}
                {{--            </div>--}}
                {{--        </div>`;--}}
                {{--            courseList.append(cardHtml);--}}
                {{--        });--}}
                {{--    },--}}
                {{--    error: function (xhr, status, error) {--}}
                {{--        console.error('Error loading courses:', error);--}}
                {{--        courseList.append('<p class="text-danger">Unable to load courses. Please try again later.</p>');--}}
                {{--    }--}}
                {{--});--}}
            });
        });
    </script>
@endpush
