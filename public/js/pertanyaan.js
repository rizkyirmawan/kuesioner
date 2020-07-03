const wrapper = document.querySelector('#pertanyaan-wrapper');
const tipeSelect = document.querySelector('#tipe-select');

let counter = 1;

wrapper.addEventListener('click', function(e) {
	const target = e.target;

	if (target.id === 'add-question') {
		e.preventDefault();

		counter++;

		target.insertAdjacentHTML('beforebegin', `
			<div id="input">
    			<label for="jawaban-${counter}" class="text-dark">Pilihan ${counter}:</label>
				<div class="input-group mb-3">
				  <div class="input-group-prepend">
				    <div class="input-group-text">
				      <input type="radio" name="jawaban-${counter}" disabled>
				    </div>
				  </div>
				  <input type="text" class="form-control" name="jawaban[][jawaban]" required>
				  <div class="input-group-append">
				    <button class="btn btn-outline-danger" type="button" id="delete-question">
				    	X
				    </button>
				  </div>
				</div>
			</div>
		`);
	}

	if (target.id === 'add-checkbox') {
		e.preventDefault();

		counter++;

		target.insertAdjacentHTML('beforebegin', `
			<div id="input">
    			<label for="jawaban-${counter}" class="text-dark">Pilihan ${counter}:</label>
				<div class="input-group mb-3">
				  <div class="input-group-prepend">
				    <div class="input-group-text">
				      <input type="checkbox" name="jawaban-${counter}" disabled>
				    </div>
				  </div>
				  <input type="text" class="form-control" name="jawaban[][jawaban]" required>
				  <div class="input-group-append">
				    <button class="btn btn-outline-danger" type="button" id="delete-question">
				    	X
				    </button>
				  </div>
				</div>
			</div>
		`);
	}

	if (target.id === 'delete-question') {
		target.parentElement.parentElement.parentElement.remove();
	}
});

tipeSelect.addEventListener('change', function(e) {
	wrapper.innerHTML = '';

	const selectedIndex = e.target.options[e.target.selectedIndex];

	counter = 1;

	switch(selectedIndex.value) {
		case 'Text':
			wrapper.insertAdjacentHTML('afterbegin', `
				<div id="input">
					<label for="jawaban" class="text-dark">Preview:</label>
					<input type="text" class="form-control" name="jawaban" disabled>
				</div>
			`);
		break;
		case 'Textarea':
			wrapper.insertAdjacentHTML('afterbegin', `
				<div id="input">
					<label for="jawaban" class="text-dark">Preview:</label>
					<textarea class="form-control" row="10" name="jawaban" disabled></textarea>
				</div>
			`);
		break;
		case 'Radio':
			wrapper.insertAdjacentHTML('afterbegin', `
	    		<div id="input">
	    			<label for="jawaban-${counter}" class="text-dark">Pilihan ${counter}:</label>
					<div class="input-group mb-3">
					  <div class="input-group-prepend">
					    <div class="input-group-text">
					      <input type="radio" name="jawaban-${counter}" disabled>
					    </div>
					  </div>
					  <input type="text" class="form-control" name="jawaban[][jawaban]" required>
					</div>
				</div>
				<button class="btn btn-block btn-info mt-2" id="add-question">
					<i class="fa fa-plus"></i>
				</button>
			`);
		break;
		case 'Checkbox':
			wrapper.insertAdjacentHTML('afterbegin', `
	    		<div id="input">
	    			<label for="jawaban-${counter}" class="text-dark">Pilihan ${counter}:</label>
					<div class="input-group mb-3">
					  <div class="input-group-prepend">
					    <div class="input-group-text">
					      <input type="checkbox" name="jawaban-${counter}" disabled>
					    </div>
					  </div>
					  <input type="text" class="form-control" name="jawaban[][jawaban]" required>
					</div>
				</div>
				<button class="btn btn-block btn-info mt-2" id="add-checkbox">
					<i class="fa fa-plus"></i>
				</button>
			`);
		break;
	}
});