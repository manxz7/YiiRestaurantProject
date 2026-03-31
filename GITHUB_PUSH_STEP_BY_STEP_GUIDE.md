# GitHub Push Step By Step Guide

This guide is for pushing this project to GitHub from the beginning.

Current situation:

- this folder was **not** a Git repository yet
- `.gitignore` now excludes `vendor`, `runtime`, and `web/assets`

---

## 1. What We Are Going To Do

We will do this flow:

1. initialize Git
2. check changed files
3. add files to Git
4. create first commit
5. create an empty GitHub repository
6. connect local project to GitHub
7. push the branch

---

## 2. Commands You Will Run

### Initialize Git

```powershell
git init
```

### Check status

```powershell
git status
```

### Add files

```powershell
git add .
```

### Create first commit

```powershell
git commit -m "Initial commit"
```

### Rename branch to main

```powershell
git branch -M main
```

### Connect to your GitHub repo

Replace the URL with your real GitHub repository URL:

```powershell
git remote add origin https://github.com/YOUR_USERNAME/YOUR_REPO_NAME.git
```

### Push to GitHub

```powershell
git push -u origin main
```

---

## 3. What To Do On GitHub Website

1. Log in to GitHub
2. Click `New repository`
3. Enter repository name
4. Choose Public or Private
5. Do **not** add README, `.gitignore`, or license from GitHub side if your local project already has files
6. Click `Create repository`

Then GitHub will show the repository URL.

---

## 4. Important Note

If Git asks for login, use your GitHub account.

If password login is rejected, GitHub usually expects:

- browser sign-in flow, or
- personal access token instead of normal password

---

## 5. What To Send Back For Checking

Send these outputs one by one:

1. `git init`
2. `git status`
3. `git commit -m "Initial commit"`
4. `git remote add origin ...`
5. `git push -u origin main`
