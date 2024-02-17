<menu class="menu tertiary-container on-tertiary-container-text">
  <div
    style="all: inherit;height: 4em;position: absolute;background: none;box-shadow: none;top: 3px;justify-content: center;flex-direction: row;">
    <a href="<?php echo base_url($locale. '/students') ?>" class="menu__item pt-1 <?php if ($from == 'students')
         echo 'active' ?>">
        <button class="menu__item <?php if ($from == 'students')
         echo 'active' ?>">
          <div class="menu__icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
              stroke="currentColor" fill="white" stroke-linecap="round" stroke-linejoin="round" class="icon">
              <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
              <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
              <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
              <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
              <path d="M21 21v-2a4 4 0 0 0 -3 -3.85"></path>
            </svg>
          </div>
          <strong class="menu__text">الطلاب</strong>
        </button>
      </a>
      <a href="<?php echo base_url($locale. '/subjects') ?>" class="menu__item pt-1 <?php if ($from == 'subjects')
           echo 'active' ?>">
        <button class="menu__item <?php if ($page_name == 'subjects')
           echo 'active' ?>">
          <div class="menu__icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
              stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" class="icon">
              <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
              <path d="M5 4m0 1a1 1 0 0 1 1 -1h2a1 1 0 0 1 1 1v14a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1z"></path>
              <path d="M9 4m0 1a1 1 0 0 1 1 -1h2a1 1 0 0 1 1 1v14a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1z"></path>
              <path d="M5 8h4"></path>
              <path d="M9 16h4"></path>
              <path
                d="M13.803 4.56l2.184 -.53c.562 -.135 1.133 .19 1.282 .732l3.695 13.418a1.02 1.02 0 0 1 -.634 1.219l-.133 .041l-2.184 .53c-.562 .135 -1.133 -.19 -1.282 -.732l-3.695 -13.418a1.02 1.02 0 0 1 .634 -1.219l.133 -.041z">
              </path>
              <path d="M14 9l4 -1"></path>
              <path d="M16 16l3.923 -.98"></path>
            </svg>
          </div>
          <strong class="menu__text">المواد</strong>
        </button>
      </a>
      <a href="<?php echo base_url($locale. '/classes') ?>" class="menu__item pt-1 <?php if ($from == 'classes')
           echo 'active' ?>">
        <button class="menu__item <?php if ($page_name == 'classes')
           echo 'active' ?>">
          <div class="menu__icon">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chalkboard" width="24" height="24"
              viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
              stroke-linejoin="round">
              <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
              <path d="M8 19h-3a2 2 0 0 1 -2 -2v-10a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v11a1 1 0 0 1 -1 1"></path>
              <path d="M11 16m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v1a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z"></path>
            </svg>
          </div>
          <strong class="menu__text">الصفوف</strong>
        </button>
      </a>
    </div>
    <ul class="nav nav-pills flex-column p-0 position-absolute" style="top: 67px;">
    <?php if ($from == "subjects"): ?>
      <li>
        <a href="<?php echo base_url($locale. '/subjects/manage_subject') ?>" class="nav-link <?php if ($page_name == 'manage_student')
             echo 'on-tertiary-text active tertiary';
           else
             echo 'on-tertiary-container-text' ?>"><i class="bi bi-columns-gap"></i> <?php echo lang('Subjects.manageSubjects')?> </a>
        </li>
        <li>
          <a href="<?php echo base_url($locale. '/subjects/add_sum') ?>" class="nav-link  <?php if ($page_name == 'add_sum')
               echo 'on-tertiary-text active tertiary';
             else
               echo 'on-tertiary-container-text' ?>"><i class="bi bi-table"></i> إضافة محصلة </a>
        </li>
        <li>
          <a href="<?php echo base_url($locale. '/subjects/sum') ?>" class="nav-link <?php if ($page_name == 'sum')
               echo 'on-tertiary-text active tertiary';
             else
               echo 'on-tertiary-container-text' ?>"><i class="bi bi-file-earmark-medical"></i> محصلات المواد </a>
        </li>
        <li>
          <a href="<?php echo base_url($locale. '/subjects/order') ?>" class="nav-link <?php if ($page_name == 'order')
               echo 'on-tertiary-text active tertiary';
             else
               echo 'on-tertiary-container-text' ?>"><i class="bi bi-sort-numeric-down"></i> ترتيب المواد </a>
        </li>
    <?php elseif ($from == "students"): ?>
      <li>
        <a href="<?php echo base_url($locale. '/students/manage_student') ?>" class="nav-link <?php if ($page_name == 'manage_student')
             echo 'on-tertiary-text active tertiary';
           else
             echo 'on-tertiary-container-text' ?>"><i class="bi bi-people"></i> إدارة الطلاب </a>
        </li>
        <li>
          <a href="<?php echo base_url($locale. '/students/edit_behav') ?>" class="nav-link <?php if ($page_name == 'edit_behav')
               echo 'on-tertiary-text active tertiary';
             else
               echo 'on-tertiary-container-text' ?>"><i class="bi bi-person-check"></i> تعديل السلوك </a>
        </li>
        <li>
          <a href="<?php echo base_url($locale. '/students/edit_absent') ?>" class="nav-link <?php if ($page_name == 'edit_absent')
               echo 'on-tertiary-text active tertiary';
             else
               echo 'on-tertiary-container-text' ?>"><i class="bi bi-person-check"></i> تعديل الغياب </a>
        </li>
        <li>
          <a href="<?php echo base_url($locale. '/students/certificate') ?>" class="nav-link <?php if ($page_name == 'certificate')
               echo 'on-tertiary-text active tertiary';
             else
               echo 'on-tertiary-container-text' ?>"><i class="bi bi-printer"></i> إصدار جلاء </a>
        </li>
        <li>
          <a href="<?php echo base_url($locale. '/students/cert') ?>" class="nav-link on-tertiary-container-text"><i
            class="bi bi-printer"></i> طباعة كافة الجلاءات </a>
      </li>
    <?php endif; ?>
    <li>
      <a href="<?php echo base_url('BackupDb') ?>" class="nav-link on-tertiary-container-text">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-database-check"
          viewBox="0 0 16 16">
          <path
            d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm1.679-4.493-1.335 2.226a.75.75 0 0 1-1.174.144l-.774-.773a.5.5 0 0 1 .708-.708l.547.548 1.17-1.951a.5.5 0 1 1 .858.514Z" />
          <path
            d="M12.096 6.223A4.92 4.92 0 0 0 13 5.698V7c0 .289-.213.654-.753 1.007a4.493 4.493 0 0 1 1.753.25V4c0-1.007-.875-1.755-1.904-2.223C11.022 1.289 9.573 1 8 1s-3.022.289-4.096.777C2.875 2.245 2 2.993 2 4v9c0 1.007.875 1.755 1.904 2.223C4.978 15.71 6.427 16 8 16c.536 0 1.058-.034 1.555-.097a4.525 4.525 0 0 1-.813-.927C8.5 14.992 8.252 15 8 15c-1.464 0-2.766-.27-3.682-.687C3.356 13.875 3 13.373 3 13v-1.302c.271.202.58.378.904.525C4.978 12.71 6.427 13 8 13h.027a4.552 4.552 0 0 1 0-1H8c-1.464 0-2.766-.27-3.682-.687C3.356 10.875 3 10.373 3 10V8.698c.271.202.58.378.904.525C4.978 9.71 6.427 10 8 10c.262 0 .52-.008.774-.024a4.525 4.525 0 0 1 1.102-1.132C9.298 8.944 8.666 9 8 9c-1.464 0-2.766-.27-3.682-.687C3.356 7.875 3 7.373 3 7V5.698c.271.202.58.378.904.525C4.978 6.711 6.427 7 8 7s3.022-.289 4.096-.777ZM3 4c0-.374.356-.875 1.318-1.313C5.234 2.271 6.536 2 8 2s2.766.27 3.682.687C12.644 3.125 13 3.627 13 4c0 .374-.356.875-1.318 1.313C10.766 5.729 9.464 6 8 6s-2.766-.27-3.682-.687C3.356 4.875 3 4.373 3 4Z" />
        </svg> نسخة احتياطية </a>
    </li>
    <li>
      <a href="<?php echo base_url('login/logout') ?>" class="nav-link on-tertiary-container-text">
        <i class="bi bi-box-arrow-in-left"></i> تسجيل الخروج </a>
    </li>
  </ul>
  <?php
  $cls = '';
  $se = session()->get('class');
  if ($se == 'c10')
    $cls = "الأول الثانوي التجاري";
  else if ($se == 'c11')
    $cls = "الثاني الثانوي التجاري";
  else if ($se == 'c12')
    $cls = "الثالث الثانوي التجاري";

  ?>

  <div class="position-absolute flex-row d-flex" style="top:347px; right:2cqw; left:2cqw;">
    <div class="d-flex w-100">
      <label for="classes" class="w-30 d-inline-block form-label" style="align-self: center;">الصف</label>
      <input id="class" name="class" list="classes" style="border-radius: 24px;"
        class="mx-1 d-inline-block form-control my-auto" autocomplete="off" value="<?php echo $cls ?>">
    </div>
    <button class="btn ms-1 active text-center my-auto"
      style="padding: 0.5rem 1rem;border-radius: 24px;width: 40%;background: #7f4894;color: #fff;border: none;"
      onclick="app.change_class()">أرسال</button>
  </div>
</menu>