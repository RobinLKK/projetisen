const wrapper = document.querySelector('.profile-wrapper');
const profileCard = wrapper.querySelector('.profile-container');
const light = profileCard.querySelector('.light');

wrapper.addEventListener('mousemove', (e) => {
    const rect = wrapper.getBoundingClientRect();
    const x = e.clientX - rect.left;
    const y = e.clientY - rect.top;

    const centerX = rect.width / 2;
    const centerY = rect.height / 2;

    const percentX = (x - centerX) / centerX;
    const percentY = (y - centerY) / centerY;

    const rotateX = percentY * -20; 
    const rotateY = percentX * 20;  

    profileCard.style.transform = `rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;

    light.style.background = `radial-gradient(circle at ${x}px ${y}px, rgba(255,255,255,0.1), transparent 80%)`;
    light.style.opacity = 1;

    const shadowX = -percentX * 40; 
    const shadowY = -percentY * 40;
    profileCard.style.boxShadow = `${shadowX}px ${shadowY}px 40px rgba(255, 255, 255, 0.1)`;
});

wrapper.addEventListener('mouseleave', () => {
    profileCard.style.transform = `rotateX(0deg) rotateY(0deg)`;
    profileCard.style.boxShadow = `0 0 30px rgba(255, 255, 255, 0.1)`;
    light.style.opacity = 0;
});
