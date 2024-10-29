create table my_users
(
    id           int auto_increment,
    name         varchar(255) not null,
    age          int          null,
    text_comment text         null,
    constraint my_users_pk
        primary key (id)
);