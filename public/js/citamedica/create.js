let $medico, $date, $especialidad, $hours;
let iRadio;

const noHoursAlert = `<div class="alert alert-danger" role="alert">
    <strong>Lo sentimos!</strong> No se encontraron horas disponibles para el médico en el día seleccionado.
</div>`;

//
// Bootstrap Datepicker
//
'use strict';
var Datepicker = (function() {
	// Variables
	var $datepicker = $('.datepicker');
	// Methods
	function init($this) {
		var options = {
			disableTouchKeyboard: true,
			autoclose: false
		};
		$this.datepicker(options);
	}
	// Events
	if ($datepicker.length) {
		$datepicker.each(function() {
			init($(this));
		});
	}
})();

$(function () {
  $especialidad = $('#especialidad');
  $medico = $('#medico');
  $date = $('#date');
  $hours = $('#hours');

  $especialidad.change(() => {
    const idEspecialidad = $especialidad.val();
    const url = `/api/medicos/especialidad/${idEspecialidad}`;
    $.getJSON(url, onMedicoLoad);
  });

 $medico.change(loadHours);
  $date.change(loadHours);
});    

function onMedicoLoad(medicos) {
  let htmlOptions = '';
  medicos.forEach(medico => {
    htmlOptions += `<option value="${medico.id}">${medico.nombre}</option>`;
  });
  $medico.html(htmlOptions);
  loadHours(); // side-effect
}

function loadHours() {
	const selectedDate = $date.val();
	const medicoId = $medico.val();
	const url = `/api/horariotrabajo/hours?date=${selectedDate}&id_medico=${medicoId}`;
    $.getJSON(url, displayHours);
}

function displayHours(data) {
	if (!data.turno1 && !data.turno2 || 
		data.turno1.length===0 && data.turno2.length===0) {

		$hours.html(noHoursAlert);
		return;
	}

	let htmlHours = '';
	iRadio = 0;

	if (data.turno1) {
		const intervaloTurno1 = data.turno1;
		intervaloTurno1.forEach(interval => {
			htmlHours += getRadioIntervalHtml(interval);
		});
	}
	if (data.turno2) {
		const intervaloTurno2 = data.turno2;
		intervaloTurno2.forEach(interval => {
			htmlHours += getRadioIntervalHtml(interval);
		});
	}
	$hours.html(htmlHours);
}

function getRadioIntervalHtml(intervalo) {
	const text = `${intervalo.inicio} - ${intervalo.fin}`;

	return `<div class="custom-control custom-radio mb-3">
  <input name="hora_consulta" value="${intervalo.inicio}" class="custom-control-input" id="interval${iRadio}" type="radio" required>
  <label class="custom-control-label" for="interval${iRadio++}">${text}</label>
</div>`;
}