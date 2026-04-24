{**
 * templates/user/lostPassword.tpl
 *
 * Copyright (c) 2013-2019 Sangia Publishing House
 * Copyright (c) 2003-2019 Rochmady and Wizdam Team
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * Password reset form.
 *
 *}
{strip}
{assign var="registerOp" value="register"}
{assign var="registerLocaleKey" value="user.login.registerNewAccount"}
{include file="core:user/lostPassword.tpl"}
{/strip}
