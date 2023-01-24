# school

Manage your students and their marks online.

This code is using Codeigniter, MD3, Bootstrap and some sample code from Codepen.

All of it is free so is this site.

It is designed for Syrian schools for now, and maybe I'll expand it for more countries.


  # ChangeLog:
  ## v1.0.0:
  - Delete <span style="color:hsl(0, 84.2%, 60.2%)">Home Controller</span> and make <span style="color:hsl(200, 98%, 39.4%)">Students Controller</span> is the default one.
  -

  ---
  ## ToDo List:
  - [x] Finish initial release.
  - [ ] Page to add multiple **students**, **marks** or even **subjects**
  -

<style>
  body {
    background: #eee
  }
  input[type=checkbox] {
    -webkit-appearance: none;
    appearance: none;
    background-color: #fff;
    margin: 0;
    font: inherit;
    color: hsl(200, 98%, 39.4%);
    width: 1.15em;
    height: 1.15em;
    border: 0.15em solid currentColor;
    border-radius: 0.15em;
    transform: translateY(-0.075em);
    display: inline-grid;
    place-content: center;
  }

  input[type=checkbox]::before {
    content: "";
    width: 0.65em;
    height: 0.65em;
    -webkit-clip-path: polygon(14% 44%, 0 65%, 50% 100%, 100% 16%, 80% 0%, 43% 62%);
    clip-path: polygon(14% 44%, 0 65%, 50% 100%, 100% 16%, 80% 0%, 43% 62%);
    transform: scale(0);
    transform-origin: bottom left;
    transition: 120ms transform ease-in-out;
    box-shadow: inset 1em 1em var(--form-control-color);
    /* Windows High Contrast Mode */
    background-color: hsl(200, 98%, 39.4%);
    display: inline;
  }

  input[type=checkbox]:checked::before {
    transform: scale(1);
  }

</style>