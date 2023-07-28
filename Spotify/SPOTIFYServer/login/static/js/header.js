$(document).ready(function() {
  let previousNation;
  $('#ActNationSel_id').on('focus', function () {
    // Store the current value on focus and on change
    previousNation = this.value;
  }).change(function() {
    const $nationForm = $('#nation-form');
    const afterProcess = () => {
      $(this).removeClass('disabled');
      $nationForm.find('.loading').addClass('d-none');
    }
    $(this).addClass('disabled');
    $nationForm.find('.loading').removeClass('d-none');
    selectedNationName = $(this).find(":selected").text();
    const data = new FormData(document.querySelector('#nation-form'));
    const handleDeleteFailed = () => {
      afterProcess();
      const $toast = $('#toast-list .toast-danger');
      $toast.find('.toast-title').html('Change nation failed');
      $toast.find('.toast-body').html(`Failed when changing nation to ${selectedNationName}`);
      $toast.toast('show');
      $(this).val(previousNation);
    }

    fetch("/Spot-SysCtrl/changeNation", {
        method: 'POST',
        body: data,
        // data: {
        //   ActNationSel_n: IN,
        //   csrfmiddlewaretoken: 'token...'
        // }
        credentials: 'same-origin',
    }).then(response => {
      if (response.ok) {
        afterProcess();
        const $toast = $('#toast-list .toast-success');
        $toast.find('.toast-title').html('Change nation successfully');
        $toast.find('.toast-body').html(`Successfully change nation to ${selectedNationName}`);
        $toast.toast('show');
      } else {
        handleDeleteFailed();
      }
    }).catch(error => {
      handleDeleteFailed();
    })
  })
});