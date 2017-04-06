<template>
	<div class="Signature__form">
		<h2 class="text-center">Northern Opticians <br> Warranty Registrations Form</h2>

		<p>
			By registering, I hereby acknowledge that my personal information is protected 
			by Northern Opticians Data Protection Policy, and hereby authorize, agree, and 
			consent to allow Northern Opticians Pte Ltd to:
		</p>

		<p>
			(a) collect, use, disclose, and/or process personal data about me that I had 
			previously provided Northern Opticians, that I now provide Northern Opticians,
			and those that I may in future provide Northern Opticians with.
		</p>

		<p>
			(b) disclose personal data about me to Northern Opticians' third party service providers
			and agents ("Representatives") that are engaged by Northern Opticians to perform 
			certain functions in relation to my purchase at Northern Opticians, such as but not
			limited to the provision of service for my purchased products or the provision of 
			eye care services to me, so long as disclosure is necessary to enable such Representatives
			to perform the said functions.
		</p>

		<p>
			(c) in addition, I hereby authorize, agree, and consent to allow Northern Opticians
			and/or its Representatives to send me such marketing, advertising, and promotional
			information and/or documents relating to Northern Opticians' products, services and 
			activities, and/or products, services and activities of third parties that Northern
			Opticians may collaborate with (the "Marketing Purpose") through the following modes
			of communication:
		</p>

		<ul>
			<li>By email to my email address</li>
			<li>By post to my address*;</li>
			<li>
				to my phone number provided to Northern Opticians by the following methods:

				<ul>
					<li>(a) Voice Calls / Phone Calls*</li>
					<li>(b) Text Messages (e.g. SMS/MMS)*</li>
				</ul>
			</li>
		</ul>

		<p>
			I also acknowledge that I have received the goods purchased by me in good condition,
			and that I will automcatically qualify for a 1 year warranty on manufacturing defects.
		</p>

		<div class="Signature__form-sign">
			<form method="POST" @submit.prevent="postAgreement">
				<div class="left-side pull-left">
					<label>Signature:</label>
					<div class="switch-element" v-if="isSign">
						<img :src="signatureData.src" class="img-responsive" :alt="signatureData.filename">
					</div>
					<div class="switch-element" v-else>
						<input type="text" name="signature" id="signature" @focus="showSignature">
					</div>
				</div>

				<div class="right-side pull-right">
					<label>Date:</label>
					<input type="date" name="date" id="date" :value="date" style="width:40%;">
				</div>

				<div class="at-bottom">
					<p>
						Should you wish to withdraw ou consent in part or in whole, please send an 
						email to our Data Protection Officer at DPO@northernopticians.com and provide
						details of your withdrawal. If you have any questions relating to our collection,
						use, and disclosure of your personal data or the matters set our above, you may
						contact our Data Protection Officer.
					</p>
				</div>

				<button type="submit" class="btn btn-info">Save</button>
			</form>
		</div>

		<!-- Customer Signature - Component -->
		<customer-signature @isSignatured="closeSignaturePad" v-if="isSignature"></customer-signature>
	</div>
</template>

<script>
	import CustomerSignature from './CustomerSignature.vue';

	export default { 
		components: { CustomerSignature },
		props: ['date'],
		data() {
			return {
				isSignature: false,
				signatureData: {},
				isSign: false,
			}
		},
		methods: {
			showSignature() {
				this.isSignature = true;
			},
			closeSignaturePad(data) {
				this.isSignature = false;
				this.signatureData = data;
				if (data) this.isSign = true;
			},
			postAgreement() {
				alert('temporary...');
			}
		}
	}
</script>