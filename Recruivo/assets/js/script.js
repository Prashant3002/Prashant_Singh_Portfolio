function toggleRoleFields() {
    const role = document.getElementById('role').value;
    const studentFields = document.getElementById('student-fields');
    const recruiterFields = document.getElementById('recruiter-fields');

    if (role === 'student') {
        studentFields.style.display = 'block';
        recruiterFields.style.display = 'none';
    } else if (role === 'recruiter') {
        recruiterFields.style.display = 'block';
        studentFields.style.display = 'none';
    } else {
        studentFields.style.display = 'none';
        recruiterFields.style.display = 'none';
    }
}
