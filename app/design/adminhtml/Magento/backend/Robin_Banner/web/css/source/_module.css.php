@robin-icons-admin__font-name-path: '@{baseDir}fonts/Robin/icomoon';

@robin-icons-admin__font-name : 'Robin';
.lib-font-face(
    @family-name:@robin-icons-admin__font-name,
    @font-path: @robin-icons-admin__font-name-path,
    @font-weight: normal,
    @font-style: normal
);

.admin__menu .item-banner-manager.parent.level-0 > a:before {
    font-family: @robin-icons-admin__font-name;
    content: "\e90d";
}