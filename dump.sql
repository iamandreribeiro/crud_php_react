-- Table: public.users

-- DROP TABLE IF EXISTS public.users;

CREATE TABLE IF NOT EXISTS public.users
(
    id integer NOT NULL DEFAULT nextval('users_id_seq'::regclass),
    name text  NOT NULL,
    cpf text  NOT NULL,
    rg text  NOT NULL,
    cep text  NOT NULL,
    logradouro text  NOT NULL,
    complemento text  NOT NULL,
    setor text  NOT NULL,
    cidade text  NOT NULL,
    uf text  NOT NULL,
    CONSTRAINT users_pkey PRIMARY KEY (id)
)

TABLESPACE pg_default;

ALTER TABLE IF EXISTS public.users
    OWNER to postgres;

    -- Table: public.phone

-- DROP TABLE IF EXISTS public.phone;

CREATE TABLE IF NOT EXISTS public.phone
(
    id integer NOT NULL DEFAULT nextval('phone_id_seq'::regclass),
    "phoneNumber" text  NOT NULL,
    "phoneDescription" text  NOT NULL,
    "userId" integer NOT NULL,
    CONSTRAINT phone_pkey PRIMARY KEY (id),
    CONSTRAINT "phone_userId_fkey" FOREIGN KEY ("userId")
        REFERENCES public.users (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
)

TABLESPACE pg_default;

ALTER TABLE IF EXISTS public.phone
    OWNER to postgres;
