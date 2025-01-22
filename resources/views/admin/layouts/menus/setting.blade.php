<button class="btn btn-danger p-3 rounded-circle d-flex align-items-center justify-content-center customizer-btn"
type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
<i class="icon ti ti-settings fs-7"></i>
</button>
<div class="offcanvas customizer offcanvas-end" tabindex="-1" id="offcanvasExample"
aria-labelledby="offcanvasExampleLabel">
<div class="d-flex align-items-center justify-content-between p-3 border-bottom">
  <h4 class="offcanvas-title fw-semibold" id="offcanvasExampleLabel">
    تنظیمات
  </h4>
  <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
</div>
<div class="offcanvas-body" data-simplebar style="height: calc(100vh - 80px)">
  <h6 class="fw-semibold fs-4 mb-2">تم</h6>

  <div class="d-flex flex-row gap-3 customizer-box" role="group">
    <input type="radio" class="btn-check light-layout" name="theme-layout" id="light-layout"
      autocomplete="off" />
    <label class="btn p-9 btn-outline-primary rounded-2" for="light-layout">
      <i class="icon ti ti-brightness-up fs-7 me-2"></i>روشن
    </label>

    <input type="radio" class="btn-check dark-layout" name="theme-layout" id="dark-layout" autocomplete="off" />
    <label class="btn p-9 btn-outline-primary rounded-2" for="dark-layout">
      <i class="icon ti ti-moon fs-7 me-2"></i>تاریک
    </label>
  </div>

  <h6 class="mt-5 fw-semibold fs-4 mb-2">جهت تم</h6>
  <div class="d-flex flex-row gap-3 customizer-box" role="group">
    <input type="radio" class="btn-check" name="direction-l" id="ltr-layout" autocomplete="off" />
    <label class="btn p-9 btn-outline-primary rounded-2" for="ltr-layout">
      <i class="icon ti ti-text-direction-ltr fs-7 me-2"></i>چپ چین
    </label>

    <input type="radio" class="btn-check" name="direction-l" id="rtl-layout" autocomplete="off" />
    <label class="btn p-9 btn-outline-primary rounded-2" for="rtl-layout">
      <i class="icon ti ti-text-direction-rtl fs-7 me-2"></i>راست چین
    </label>
  </div>

  <h6 class="mt-5 fw-semibold fs-4 mb-2">رنگ تم</h6>

  <div class="d-flex flex-row flex-wrap gap-3 customizer-box color-pallete" role="group">
    <input type="radio" class="btn-check" name="color-theme-layout" id="Blue_Theme" autocomplete="off" />
    <label class="btn p-9 btn-outline-primary rounded-2 d-flex align-items-center justify-content-center"
      onclick="handleColorTheme('Blue_Theme')" for="Blue_Theme" data-bs-toggle="tooltip" data-bs-placement="top"
      data-bs-title="BLUE_THEME">
      <div class="color-box rounded-circle d-flex align-items-center justify-content-center skin-1">
        <i class="ti ti-check text-white d-flex icon fs-5"></i>
      </div>
    </label>

    <input type="radio" class="btn-check" name="color-theme-layout" id="Aqua_Theme" autocomplete="off" />
    <label class="btn p-9 btn-outline-primary rounded-2 d-flex align-items-center justify-content-center"
      onclick="handleColorTheme('Aqua_Theme')" for="Aqua_Theme" data-bs-toggle="tooltip" data-bs-placement="top"
      data-bs-title="AQUA_THEME">
      <div class="color-box rounded-circle d-flex align-items-center justify-content-center skin-2">
        <i class="ti ti-check text-white d-flex icon fs-5"></i>
      </div>
    </label>

    <input type="radio" class="btn-check" name="color-theme-layout" id="Purple_Theme" autocomplete="off" />
    <label class="btn p-9 btn-outline-primary rounded-2 d-flex align-items-center justify-content-center"
      onclick="handleColorTheme('Purple_Theme')" for="Purple_Theme" data-bs-toggle="tooltip"
      data-bs-placement="top" data-bs-title="PURPLE_THEME">
      <div class="color-box rounded-circle d-flex align-items-center justify-content-center skin-3">
        <i class="ti ti-check text-white d-flex icon fs-5"></i>
      </div>
    </label>

    <input type="radio" class="btn-check" name="color-theme-layout" id="green-theme-layout"
      autocomplete="off" />
    <label class="btn p-9 btn-outline-primary rounded-2 d-flex align-items-center justify-content-center"
      onclick="handleColorTheme('Green_Theme')" for="green-theme-layout" data-bs-toggle="tooltip"
      data-bs-placement="top" data-bs-title="GREEN_THEME">
      <div class="color-box rounded-circle d-flex align-items-center justify-content-center skin-4">
        <i class="ti ti-check text-white d-flex icon fs-5"></i>
      </div>
    </label>

    <input type="radio" class="btn-check" name="color-theme-layout" id="cyan-theme-layout" autocomplete="off" />
    <label class="btn p-9 btn-outline-primary rounded-2 d-flex align-items-center justify-content-center"
      onclick="handleColorTheme('Cyan_Theme')" for="cyan-theme-layout" data-bs-toggle="tooltip"
      data-bs-placement="top" data-bs-title="CYAN_THEME">
      <div class="color-box rounded-circle d-flex align-items-center justify-content-center skin-5">
        <i class="ti ti-check text-white d-flex icon fs-5"></i>
      </div>
    </label>

    <input type="radio" class="btn-check" name="color-theme-layout" id="orange-theme-layout"
      autocomplete="off" />
    <label class="btn p-9 btn-outline-primary rounded-2 d-flex align-items-center justify-content-center"
      onclick="handleColorTheme('Orange_Theme')" for="orange-theme-layout" data-bs-toggle="tooltip"
      data-bs-placement="top" data-bs-title="ORANGE_THEME">
      <div class="color-box rounded-circle d-flex align-items-center justify-content-center skin-6">
        <i class="ti ti-check text-white d-flex icon fs-5"></i>
      </div>
    </label>
  </div>

</div>
</div>
</div>