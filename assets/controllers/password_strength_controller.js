import { Controller } from '@hotwired/stimulus';
import zxcvbn from 'zxcvbn';

/*
* The following line makes this controller "lazy": it won't be downloaded until needed
* See https://github.com/symfony/stimulus-bridge#lazy-controllers
*/
/* stimulusFetch: 'lazy' */
export default class extends Controller {
    update(event) {
        const score = zxcvbn(event.target.value).score;

        updateStrengthBar(score);
        toggleDisableButton(score);
        showText(score);
    }
}

const showText = (score) => {
    const weakPasswordText = document.getElementById('weakPasswordText');
    const mediumPasswordText = document.getElementById('mediumPasswordText');
    const strongPasswordText = document.getElementById('strongPasswordText');

    weakPasswordText.classList.toggle('d-none', score > 1)
    mediumPasswordText.classList.toggle('d-none', score <= 1 || score > 2)
    strongPasswordText.classList.toggle('d-none', score <= 2)
}

const getProgressColor = (score) => {
    switch (score) {
        case 0:
        case 1:
            return 'bg-danger';
        case 2:
            return 'bg-warning';
        case 3:
        case 4:
            return 'bg-success';
    }
}

const computePercentage = (score) => {
    const percentage = (score + 1) * 20;

    return percentage === 0 ? '1%' : `${percentage}%`;
}

const toggleDisableButton = (score) => {
    const isPasswordValid = score >= 3;
    const formButton = document.getElementById('passwordFormButton');
    formButton.disabled = !isPasswordValid;
    formButton.classList.toggle('disabled', !isPasswordValid);
}

const updateStrengthBar = (score) => {
    const progress = document.getElementById('passwordStrengthProgress');
    progress.classList.remove('bg-danger', 'bg-warning', 'bg-success');
    const strengthPercentage = computePercentage(score);
    progress.style.width = strengthPercentage
    progress.ariaValueText = strengthPercentage
    progress.classList.add(getProgressColor(score));
}
