<template>
	<div class="Signature-overlay">
		<div class="Signature-scroll">
			<div class="Signature">
				<button type="button" class="btn btn-danger" @click.prevent="$emit('isSignatured')">x</button>
				<h2>Signature</h2> <hr>
				<canvas></canvas>

				<div class="Signature__controls">
					<button type="button" class="btn btn-info" @click="postSignature">Save</button>
					<button type="button" class="btn btn-warning" @click="clearSignature">Clear</button>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	import SignaturePad from 'signature_pad';

	export default {
		data() {
			return {
				canvas: '',
				signaturePad: {},
				filename: '',
			}
		},
		mounted() {
			this.onInitSignature();
			window.addEventListener("resize", this.resizeCanvas);
		},
		computed: {
			pathOfFile() {
				return '/img/signatures/' + this.filename;
			}
		},
		methods: {
			onInitSignature() {
				this.canvas = document.querySelector('canvas');
				this.signaturePad = new SignaturePad(this.canvas, {});
				this.resizeCanvas();
			},
			resizeCanvas() {
			    let ratio =  Math.max(window.devicePixelRatio || 1, 1);
			    let canvas = this.canvas;
			    let signaturePad = this.signaturePad;

			    canvas.width = canvas.offsetWidth * ratio;
			    canvas.height = canvas.offsetHeight * ratio;
			    canvas.getContext("2d").scale(ratio, ratio);
			    signaturePad.clear(); // otherwise isEmpty() might return incorrect value
			},
			postSignature() {
				let signaturePad = this.signaturePad;

				if (!signaturePad.isEmpty()) {
					let meta = signaturePad.toDataURL();

					// post to server
					axios.post('/customers/postSignature', { meta: meta })
						.then(response => {
							let data = response.data;
							this.filename = data.filename;

							if (data <= 0 || data == false) {
								// notify for error
								noty({
									layout: 'bottomLeft',
									theme: 'relax', // or relax
									type: 'error', // success, error, warning, information, notification
									text: `Error encountered.`,
									timeout: 5000,
								});
							} else {
								// notify for success
								/*noty({
									layout: 'bottomLeft',
									theme: 'relax', // or relax
									type: 'success', // success, error, warning, information, notification
									text: `
										<div class="noty-message">
											<h5>Signature successfully saved.</h5>

											<img src="${this.pathOfFile}" alt="${this.filename}" width="170" height="120">
										</div>
									`,
									timeout: 5000,
								});*/

								this.$emit('isSignatured', { src: this.pathOfFile, filename: this.filename}); // close the signature pad
							}
						});
				}
			},
			clearSignature() {
				let signaturePad = this.signaturePad;
				!signaturePad.isEmpty() && signaturePad.clear();
			}
		}
	}
</script>

<style scoped>
	canvas {
		background: #DBD7D7;
		width: 100%;
		height: 60vh;
		border: 1px solid silver;
	}
</style>