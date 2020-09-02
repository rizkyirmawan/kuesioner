const spinner = document.querySelector('#loading-spinner');
const kelasSelect = document.querySelector('#kelas-select');
const jurusanSelect = document.querySelector('#jurusan-select');
const angkatanSelect = document.querySelector('#angkatan-select');
const unchosenList = document.querySelector('#unchosen-list');
const chosenList = document.querySelector('#chosen-list');
const wrapper = document.querySelector('#peserta-wrapper');
const btnSimpan = document.querySelector('#btn-simpan');
const silahkanPilih = document.querySelector('#silahkan-pilih');
const belumAda = document.querySelector('#belum-ada');

let chosenData = [];

let unchosenData = [];

let jurusanIds = [];

spinner.style.display = 'none';
angkatanSelect.style.display = 'none';
jurusanSelect.style.display = 'none';
btnSimpan.setAttribute('disabled', '');

document.addEventListener('DOMContentLoaded', async function() {
	const arrUrl = location.href.split('/');
	const matkulId = arrUrl[5];

	const res = await fetch(`/users/mahasiswa/data/matkul/${matkulId}`);
	const jurusan = await fetch(`/master/mata-kuliah/${matkulId}/jurusan`);
	const dataJurusan = await jurusan.json();
	jurusanIds = dataJurusan.map(item => item.id);
	let data = await res.json();

	chosenData = data.map(item => item.id);

	toggleText();

	toggleButton();

	data.forEach(e => {
		chosenList.insertAdjacentHTML(
			'afterbegin',
			`
			<a href="#" 
				id="mahasiswa-chosen"
				data-nim="${e.nim}"
				data-nama="${e.nama}"
				data-id="${e.id}"
				class="list-group-item list-group-item-action">${e.nim}: ${e.nama}</a>
			<input type="hidden" value="${e.nim}" name="mahasiswa[]">`
		);
	});

	console.log(data);
});

kelasSelect.addEventListener('change', async function(e) {
	unchosenList.innerHTML = '';

	spinner.style.display = 'block';
	angkatanSelect.style.display = 'none';
	jurusanSelect.style.display = 'none';
	angkatanSelect.selectedIndex = 0;
	jurusanSelect.selectedIndex = 0;
	angkatanSelect.innerHTML = '<option selected disabled>Pilih Angkatan</option>';
	silahkanPilih.classList.add('d-none');

	const res = await fetch(`/users/mahasiswa/data/${this.value}`);
	let data = await res.json();

	data = data.filter(item => jurusanIds.includes(item.jurusan_id) && !chosenData.includes(item.id));
	unchosenData = data.filter(item => item.id !== chosenData.includes(item));
	unchosenData = unchosenData.map(item => item.id);

	spinner.style.display = 'none';
	jurusanSelect.style.display = 'block';

	let angkatan = data.map(item => item.angkatan);
	let uniqueAngkatan = [...new Set(angkatan)];

	uniqueAngkatan.forEach(e => {
		angkatanSelect.insertAdjacentHTML(
			'beforeend',
			`<option value='${e}'>${e}</option>`
		);
	});

	data.forEach(e => {
		unchosenList.insertAdjacentHTML(
			'afterbegin',
			`
			<a href="#"
				id="mahasiswa-unchosen" 
				class="list-group-item list-group-item-action"
				data-nim="${e.nim}"
				data-id="${e.id}" 
				data-nama="${e.nama}"
			>${e.nim}: ${e.nama}</a>`
		);
	});

	toggleText();
});

jurusanSelect.addEventListener('change', async function() {
	unchosenList.innerHTML = '';

	spinner.style.display = 'block';
	angkatanSelect.style.display = 'none';
	angkatanSelect.selectedIndex = 0;
	angkatanSelect.innerHTML = '<option selected disabled>Pilih Angkatan</option>';
	silahkanPilih.classList.add('d-none');

	const res = await fetch(
		`/users/mahasiswa/data/${
			kelasSelect.options[kelasSelect.selectedIndex].value
		}/${this.value}`
	);

	let data = await res.json();

	unchosenData = data.map(item => item.id);
	data = data.filter(item => !chosenData.includes(item.id));
	unchosenData = unchosenData.filter(item => !chosenData.includes(item));

	spinner.style.display = 'none';
	angkatanSelect.style.display = 'block';

	let angkatan = data.map(item => item.angkatan);
	let uniqueAngkatan = [...new Set(angkatan)];

	uniqueAngkatan.forEach(e => {
		angkatanSelect.insertAdjacentHTML(
			'beforeend',
			`<option value='${e}'>${e}</option>`
		);
	});

	data.forEach(e => {
		unchosenList.insertAdjacentHTML(
			'afterbegin',
			`
			<a href="#"
				id="mahasiswa-unchosen" 
				class="list-group-item list-group-item-action"
				data-nim="${e.nim}"
				data-id="${e.id}" 
				data-nama="${e.nama}"
			>${e.nim}: ${e.nama}</a>`
		);
	});

	toggleText();
});

angkatanSelect.addEventListener('change', async function() {
	unchosenList.innerHTML = '';

	spinner.style.display = 'block';
	silahkanPilih.classList.add('d-none');

	const res = await fetch(
		`/users/mahasiswa/data/${
			kelasSelect.options[kelasSelect.selectedIndex].value
		}/${jurusanSelect.options[jurusanSelect.selectedIndex].value}/${
			this.value
		}`
	);

	let data = await res.json();

	unchosenData = data.map(item => item.id);
	data = data.filter(item => !chosenData.includes(item.id));
	unchosenData = unchosenData.filter(item => !chosenData.includes(item));

	spinner.style.display = 'none';
	angkatanSelect.style.display = 'block';

	data.forEach(e => {
		unchosenList.insertAdjacentHTML(
			'afterbegin',
			`
			<a href="#"
				id="mahasiswa-unchosen" 
				class="list-group-item list-group-item-action"
				data-nim="${e.nim}"
				data-id="${e.id}" 
				data-nama="${e.nama}"
			>${e.nim}: ${e.nama}</a>`
		);
	});

	toggleText();
});

wrapper.addEventListener('click', function(e) {
	const target = e.target;

	if (target.id === 'mahasiswa-unchosen') {
		e.preventDefault();

		chosenData.push(Number(target.dataset.id));
		unchosenData = unchosenData.filter(
			item => item !== Number(target.dataset.id)
		);

		target.parentNode.removeChild(target);

		chosenList.insertAdjacentHTML(
			'afterbegin',
			`
			<a href="#" 
				id="mahasiswa-chosen"
				data-nim="${target.dataset.nim}"
				data-nama="${target.dataset.nama}"
				data-id="${target.dataset.id}"
				class="list-group-item list-group-item-action">${target.dataset.nim}: ${target.dataset.nama}</a>
			<input type="hidden" value="${target.dataset.nim}" name="mahasiswa[]">`
		);

		toggleButton();

		toggleText();
	}

	if (target.id === 'mahasiswa-chosen') {
		e.preventDefault();

		unchosenData.push(Number(target.nextElementSibling.value));
		chosenData = chosenData.filter(
			item => item !== Number(target.nextElementSibling.value)
		);

		unchosenList.insertAdjacentHTML(
			'afterbegin',
			`
			<a href="#"
				id="mahasiswa-unchosen" 
				class="list-group-item list-group-item-action"
				data-nim="${target.dataset.nim}"
				data-id="${target.dataset.id}" 
				data-nama="${target.dataset.nama}"
			>${target.dataset.nim}: ${target.dataset.nama}</a>`
		);

		toggleButton();

		toggleText();

		target.nextElementSibling.remove();
		target.parentNode.removeChild(target);
	}
});

function toggleText() {
	if (chosenData.length <= 0) {
		belumAda.classList.remove('d-none');
	} else if (chosenData.length > 0) {
		belumAda.classList.add('d-none');
	}

	if (unchosenData.length <= 0) {
		silahkanPilih.classList.remove('d-none');
	} else if (unchosenData.length > 0) {
		silahkanPilih.classList.add('d-none');
	}
}

function toggleButton() {
	if (chosenData.length <= 0) {
		btnSimpan.setAttribute('disabled', '');
	} else if (chosenData.length > 0) {
		btnSimpan.removeAttribute('disabled');
	}
}