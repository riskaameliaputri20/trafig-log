<x-layouts.dashboard title="Setting Account">
    <form action="{{ route('dashboard.setting.account.update') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="position-relative mx-n4 mt-n4">
            <div class="profile-wid-bg profile-setting-img">
                <img src="{{ asset('dashboard/assets/images/profile-bg.jpg') }}" class="profile-wid-img" alt="">

            </div>
        </div>

        <div class="row">
            <div class="col-xxl-3">
                <div class="card mt-n5">
                    <div class="card-body p-4">
                        <div class="text-center">
                            <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
                                <img src="{{ Storage::url(auth()->user()->profile) }}"
                                    class="rounded-circle avatar-xl img-thumbnail user-profile-image material-shadow"
                                    alt="user-profile-image">
                                <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
                                    <input id="profile-img-file-input" name="profile" type="file"
                                        class="profile-img-file-input" accept="image/*">
                                    <label for="profile-img-file-input" class="profile-photo-edit avatar-xs">
                                        <span class="avatar-title rounded-circle bg-light text-body material-shadow">
                                            <i class="ri-camera-fill"></i>
                                        </span>
                                    </label>
                                </div>
                            </div>
                            <h5 class="fs-16 mb-1 text-capitalize">{{ auth()->user()->name }}</h5>
                            <p class="text-muted mb-0 text-uppercase">Admin</p>
                        </div>
                    </div>
                </div>
                <!--end card-->
            </div>
            <!--end col-->
            <div class="col-xxl-9">
                <div class="card mt-xxl-n5">

                    <div class="card-body p-4">

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="nameInput" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="nameInput"
                                        placeholder="Masukkan Nama" value="{{ $user->name }}" name="name">
                                    @error('name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror

                                </div>
                                <div class="mb-3">
                                    <label for="emailInput" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="emailInput"
                                        placeholder="Masukkan New Email" value="{{ $user->email }}" name="email">
                                    @error('email')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror

                                </div>
                                <div class="mb-3">
                                    <label for="passwordInput" class="form-label">New Password (optional)</label>
                                    <input type="password" class="form-control" id="passwordInput"
                                        placeholder="Masukkan Password Baru (Optional)" name="password">
                                    @error('password')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror

                                </div>
                            </div>

                            <!--end col-->
                            <div class="col-lg-12">
                                <div class="hstack gap-2 justify-content-end">
                                    <button type="submit" class="btn btn-primary">Updates</button>
                                    <button type="reset" class="btn btn-soft-danger">Cancel</button>
                                </div>
                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->

                    </div>
                </div>
            </div>
            <!--end col-->
        </div>
        <!--end row-->
    </form>
</x-layouts.dashboard>
